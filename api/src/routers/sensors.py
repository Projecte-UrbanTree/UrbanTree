from typing import List
from fastapi import APIRouter, Depends
from sqlmodel import Session, select

from src.database import get_session
from src.models.api_response_model import ApiResponse, ErrorResponse
from src.models.sensor_model import Sensor


router = APIRouter(prefix="/api/sensors", tags=["Sensors"])


@router.get("/", response_model=ApiResponse[List[Sensor]])
async def get_sensors(db: Session = Depends(get_session)):
    sensors: List[Sensor] = db.exec(select(Sensor)).all()
    return ApiResponse(status=ApiResponse.status, detail=sensors)


@router.get("{sensor_id}")
async def get_sensor(sensor_id: int, db: Session = Depends(get_session)):
    sensor: Sensor = db.get(Sensor, sensor_id)

    if not sensor:
        return ErrorResponse(
            status=ErrorResponse.status, code=404, message="Sensor not found"
        )

    return ApiResponse(status=ApiResponse.status, details=sensor)
