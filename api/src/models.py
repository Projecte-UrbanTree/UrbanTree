from datetime import datetime

from sqlmodel import Field, Relationship, SQLModel


class Sensor(SQLModel, table=True):
    __tablename__ = "sensors"

    id: int | None = Field(default=None, primary_key=True)

    contract_id: int = Field(index=True)
    zone_id: int = Field(index=True)
    point_id: int = Field(index=True)
    model: str | None = Field(default=None, index=True)
    is_active: bool | None = Field(default=None, index=True)

    histories: list["SensorHistory"] = Relationship(back_populates="sensor")


class SensorHistoryBase(SQLModel):
    temperature: float
    humidity: float
    inclination: float
    created_at: datetime

    sensor_id: int = Field(foreign_key="sensors.id")


class SensorHistory(SensorHistoryBase, table=True):
    __tablename__ = "sensor_history"

    id: int | None = Field(default=None, primary_key=True)
    temperature: float
    humidity: float
    inclination: float

    sensor: Sensor = Relationship(back_populates="histories")


class SensorHistoryCreate(SensorHistoryBase):
    pass
