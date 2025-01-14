from typing import TYPE_CHECKING, Optional, List
from sqlmodel import Field, Relationship, SQLModel

if TYPE_CHECKING:
    from .sensor_history_model import SensorHistory


class Sensor(SQLModel, table=True):
    __tablename__ = "sensors"

    id: Optional[int] = Field(default=None, primary_key=True)
    contract_id: int = Field(foreign_key="contracts.id", index=True)
    zone_id: int = Field(index=True)
    point_id: int = Field(index=True, unique=True)
    model: Optional[str] = Field(default=None)
    is_active: Optional[bool] = Field(default=None)

    histories: List["SensorHistory"] = Relationship(back_populates="sensor")

    class Config:
        from_attributes = True
