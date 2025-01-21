from typing import List, Union

from fastapi import APIRouter, Depends
from sqlalchemy.orm import joinedload
from sqlmodel import Session, select
from src.database import get_session
from src.models.api_response_model import ApiResponse, ErrorResponse
from src.models.sensor_history_model import SensorHistory
from src.models.sensor_model import Sensor
from src.schemas.sensor_response import SensorResponse

router = APIRouter(prefix="/api/v1/sensors", tags=["Sensors"])


@router.get("/", response_model=ApiResponse[List[SensorResponse]])
async def get_sensors(db: Session = Depends(get_session)):
    sensors = (
        db.exec(select(Sensor).options(joinedload(Sensor.histories))).unique().all()
    )

    return ApiResponse(status="success", details=sensors)


@router.get("/{sensor_id}")
async def get_sensor(sensor_id: int, db: Session = Depends(get_session)):
    sensor: Sensor = db.get(Sensor, sensor_id)

    if not sensor:
        return ErrorResponse(status="error", code=404, message="Sensor not found")

    return ApiResponse(status="success", details=sensor)


@router.get(
    "/{sensor_id}/history",
    response_model=Union[ApiResponse[SensorHistory], ErrorResponse],
)
async def get_sensor_history(sensor_id: int, db: Session = Depends(get_session)):
    sensor: Sensor = db.get(Sensor, sensor_id)

    if not sensor:
        return ErrorResponse(status="error", code=404, message="Sensor not found")

    sensor_history: SensorHistory = db.get(SensorHistory, sensor.id)

    if not sensor_history:
        return ErrorResponse(
            status="error", code=404, message="Sensor history not found"
        )

    return ApiResponse(status="success", details=sensor_history)
