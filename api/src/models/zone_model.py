# models/zone_model.py

from datetime import datetime
from typing import TYPE_CHECKING, Optional
from sqlmodel import Field, Relationship, SQLModel

if TYPE_CHECKING:
    from .contract_model import Contract

class ZoneBase(SQLModel):
    contract_id: int = Field(foreign_key="contracts.id", nullable=False)
    name: Optional[str] = Field(default=None, max_length=255)
    color: Optional[str] = Field(default=None, max_length=7)
    description: Optional[str] = Field(default=None, max_length=255)
    created_at: datetime
    updated_at: Optional[datetime]
    deleted_at: Optional[datetime]

class Zone(ZoneBase, table=True):
    __tablename__ = "zones"

    id: int | None = Field(default=None, primary_key=True)

    contract: "Contract" = Relationship(back_populates="zones")

class ZoneCreate(ZoneBase):
    pass
