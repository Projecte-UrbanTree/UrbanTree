import os
from typing import List
from fastapi import APIRouter, Request, Depends
from fastapi.templating import Jinja2Templates
from sqlmodel import Session, select

from src.database import get_session
from src.models.sensor_model import Sensor
from src.models.sensor_history_model import SensorHistory


templates = Jinja2Templates(
    directory=os.path.join(os.path.dirname(__file__), "../templates")
)


router = APIRouter()


@router.get("/")
def hello():
    return "Hello, Docker!"


@router.get("/sensors", response_model=List[Sensor])
def get_sensor_data(*, db: Session = Depends(get_session), request: Request):
    sensors: List[Sensor] = db.exec(select(Sensor)).all()
    return templates.TemplateResponse(
        "index.html", {"request": request, "sensors": sensors}
    )


@router.get("/sensor/{sensor_id}")
async def get_sensor_history(
    sensor_id: int, request: Request, db: Session = Depends(get_session)
):
    sensor: Sensor = db.query(Sensor).filter(Sensor.id == sensor_id).first()

    if sensor is None:
        return templates.TemplateResponse("not_found.html", {"request": request})

    sensor_history: List[SensorHistory] = (
        db.query(SensorHistory).filter(SensorHistory.sensor_id == sensor_id).all()
    )

    sensor_history.sort(key=lambda x: x.created_at, reverse=True)

    return templates.TemplateResponse(
        "sensor_detail.html",
        {
            "request": request,
            "sensor": sensor,
            "sensor_history": sensor_history,
        },
    )
