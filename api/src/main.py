from contextlib import asynccontextmanager

import sentry_sdk
from fastapi import FastAPI
from sqlmodel import Session, SQLModel, create_engine
from src.config import settings
from src.services.sensor_service import insert_data
from src.utils.file_loader import load_sensor_data

sentry_sdk.init(
    dsn=settings.SENTRY_DSN,
    environment=settings.APP_ENV,
    release=settings.SENTRY_RELEASE,
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

engine = create_engine(str(settings.SQLALCHEMY_DATABASE_URI))


def create_db_and_tables():
    SQLModel.metadata.create_all(engine)


@asynccontextmanager
async def lifespan(app: FastAPI):
    create_db_and_tables()
    sensor_data = load_sensor_data("./sensors.json")
    with Session(engine) as session:
        if sensor_data:
            insert_data(sensor_data, session)
        else:
            print("No data to insert")
    yield


app = FastAPI(lifespan=lifespan)


@app.get("/")
def hello():
    return "Hello, Docker!"


@app.get("/health")
def health_check():
    return {"status": "healthy"}
