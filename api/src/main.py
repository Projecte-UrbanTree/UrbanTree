import os
from contextlib import asynccontextmanager
from typing import List

import sentry_sdk
import sentry_sdk.crons
from fastapi import Depends, FastAPI, Request, Response
from fastapi.responses import JSONResponse
from fastapi.staticfiles import StaticFiles
from fastapi.templating import Jinja2Templates
from sqlmodel import Session, select

from .config import settings
from .database import create_db_and_tables, get_session
from .models import ApiResponse, Sensor, SensorHistory, User, UserResponse
from .services.scheduler_service import scheduler

# Initialize Sentry SDK
sentry_sdk.init(
    dsn=settings.SENTRY_DSN,
    environment=settings.APP_ENV,
    release=settings.IMAGE_VERSION,
    enable_tracing=True,
    # Set traces_sample_rate to 1.0 to capture 100%
    # of transactions for tracing.
    traces_sample_rate=1.0,
    # Set profiles_sample_rate to 1.0 to profile 100%
    # of sampled transactions.
    # We recommend adjusting this value in production.
    profiles_sample_rate=1.0,
    _experiments={
        # Set continuous_profiling_auto_start to True
        # to automatically start the profiler on when
        # possible.
        "continuous_profiling_auto_start": True,
    },
)


@asynccontextmanager
async def lifespan(app: FastAPI):
    create_db_and_tables()
    scheduler.start()
    yield
    scheduler.shutdown()


app = FastAPI(lifespan=lifespan)

app.mount("/static", StaticFiles(directory="src/static"), name="static")

templates = Jinja2Templates(
    directory=os.path.join(os.path.dirname(__file__), "templates")
)


@app.get("/")
def hello():
    return "Hello, Docker!"


@app.get("/health")
def health_check():
    return {"status": "healthy", "version": settings.IMAGE_VERSION or "dev"}


@app.get("/sensors", response_model=list[Sensor])
def get_sensor_data(*, db: Session = Depends(get_session), request: Request):
    sensors: List[Sensor] = db.exec(select(Sensor)).all()
    return templates.TemplateResponse(
        "index.html", {"request": request, "sensors": sensors}
    )


from fastapi import Request


@app.get("/sensor/{sensor_id}")
async def get_sensor_history(
    sensor_id: int, request: Request, db: Session = Depends(get_session)
):
    sensor = db.query(Sensor).filter(Sensor.id == sensor_id).first()

    if sensor is None:
        return templates.TemplateResponse("not_found.html", {"request": request})

    sensor_history = (
        db.query(SensorHistory).filter(SensorHistory.sensor_id == sensor_id).all()
    )

    return templates.TemplateResponse(
        "sensor_detail.html",
        {"request": request, "sensor": sensor, "sensor_history": sensor_history},
    )


@app.get("/users", response_model=ApiResponse[List[User]])
def get_users(db: Session = Depends(get_session)):
    users: List[User] = db.exec(select(User)).all()

    user_responses = [
        {
            key: value
            for key, value in user.dict().items()
            if key not in ["password", "created_at", "updated_at", "deleted_at"]
        }
        for user in users
    ]

    if not users:
        return ApiResponse(
            status="error",
            details=[],
            message="No users found",
            status_code=404,
        )

    return ApiResponse(
        status="success",
        details=user_responses,
        message="Users retrieved successfully",
        status_code=200,
    )
