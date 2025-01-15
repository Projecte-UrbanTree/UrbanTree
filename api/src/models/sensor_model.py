from datetime import datetime
from typing import List, Optional
from sqlmodel import Field, Relationship, SQLModel

from src.models.zone_model import Zone
from src.models.contract_model import Contract
from src.models.sensor_history_model import SensorHistory


class Sensor(SQLModel, table=True):
    __tablename__ = "sensors"

    id: Optional[int] = Field(default=None, primary_key=True)
    contract_id: int = Field(foreign_key="contracts.id", index=True)
    zone_id: int = Field(foreign_key="zones.id", index=True)
    point_id: int = Field(index=True, unique=True)
    model: Optional[str] = Field(default=None)
    is_active: Optional[bool] = Field(default=None)
    created_at: datetime = Field(default_factory=datetime.utcnow)

    contract: Optional["Contract"] = Relationship(back_populates="sensors")

    zone: Optional["Zone"] = Relationship(back_populates="sensors")

    histories: List["SensorHistory"] = Relationship(back_populates="sensor")

    class Config:
        from_attributes = True
