from datetime import datetime
from sqlmodel import Field, Relationship, SQLModel
from typing import TYPE_CHECKING

if TYPE_CHECKING:
    from .sensor_model import Sensor

class SensorHistoryBase(SQLModel):
    temperature: float
    humidity: float
    inclination: float
    created_at: datetime

    sensor_id: int = Field(foreign_key="sensors.id")


class SensorHistory(SensorHistoryBase, table=True):
    __tablename__ = "sensor_history"

    id: int | None = Field(default=None, primary_key=True)

    sensor: "Sensor" = Relationship(back_populates="histories")


class SensorHistoryCreate(SensorHistoryBase):
    pass
