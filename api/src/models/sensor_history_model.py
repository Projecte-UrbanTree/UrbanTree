from datetime import datetime
from sqlmodel import Field, Relationship, SQLModel
from typing import Optional, TYPE_CHECKING

if TYPE_CHECKING:
    from .sensor_model import Sensor


class SensorHistory(SQLModel, table=True):
    __tablename__ = "sensor_history"

    id: Optional[int] = Field(default=None, primary_key=True)
    sensor_id: int = Field(foreign_key="sensors.id", index=True)
    temperature: float
    humidity: float
    inclination: float
    created_at: datetime

    sensor: "Sensor" = Relationship(back_populates="histories")

    class Config:
        from_attributes = True
