import os
from contextlib import asynccontextmanager
from typing import List

import sentry_sdk
import sentry_sdk.crons
from fastapi import Depends, FastAPI, Request
from fastapi.staticfiles import StaticFiles
from fastapi.templating import Jinja2Templates
from sqlmodel import Session, select

from src.routers import pages, sensors

from .config import settings
from .database import create_db_and_tables, get_session
from .models.sensor_model import Sensor, SensorHistory
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

app.include_router(pages.router)
app.include_router(sensors.router)


@app.get("/health")
def health_check():
    return {"status": "healthy"}
