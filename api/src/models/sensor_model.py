from datetime import datetime
from typing import TYPE_CHECKING

from sqlmodel import Field, Relationship, SQLModel

if TYPE_CHECKING:
    from .element_model import Element


class Sensor(SQLModel, table=True):
    __tablename__ = "sensors"

    id: int | None = Field(default=None, primary_key=True)

    zone_id: int = Field(index=True)
    point_id: int = Field(index=True)
    model: str | None = Field(default=None, index=True)
    is_active: bool | None = Field(default=None, index=True)

    histories: list["SensorHistory"] = Relationship(back_populates="sensor")

    contract_id: int = Field(index=True)


class SensorHistoryBase(SQLModel):
    temperature: float
    humidity: float
    inclination: float
    created_at: datetime

    sensor_id: int = Field(foreign_key="sensors.id")


class SensorHistory(SensorHistoryBase, table=True):
    __tablename__ = "sensor_history"

    id: int | None = Field(default=None, primary_key=True)

    sensor: Sensor = Relationship(back_populates="histories")


class SensorHistoryCreate(SensorHistoryBase):
    pass
