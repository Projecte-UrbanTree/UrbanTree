from datetime import datetime
from typing import TYPE_CHECKING, Optional, List
from sqlmodel import Field, Relationship, SQLModel

if TYPE_CHECKING:
    from .sensor_model import Sensor


class Contract(SQLModel, table=True):
    __tablename__ = "contracts"

    id: Optional[int] = Field(default=None, primary_key=True)
    name: str
    start_date: str
    end_date: Optional[str]
    invoice_proposed: Optional[float]
    invoice_agreed: Optional[float]
    invoice_paid: Optional[float]
    created_at: datetime = Field(default_factory=datetime.utcnow)
    updated_at: Optional[datetime]
    deleted_at: Optional[datetime]
