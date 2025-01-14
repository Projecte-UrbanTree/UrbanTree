from typing import TYPE_CHECKING

from sqlmodel import Field, Relationship, SQLModel

if TYPE_CHECKING:
    from .element_model import Element
    from .sensor_history_model import SensorHistory
    from .contract_model import Contract


class Sensor(SQLModel, table=True):
    __tablename__ = "sensors"

    id: int | None = Field(default=None, primary_key=True)

    zone_id: int = Field(index=True)
    point_id: int = Field(index=True)
    model: str | None = Field(default=None, index=True)
    is_active: bool | None = Field(default=None, index=True)

    histories: list["SensorHistory"] = Relationship(back_populates="sensor")

    contract_id: int = Field(index=True)
    contract: "Contract" = Relationship(back_populates="sensors")

