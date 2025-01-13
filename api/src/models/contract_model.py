from datetime import datetime
from typing import TYPE_CHECKING, Optional, List

from sqlmodel import Field, Relationship, SQLModel

if TYPE_CHECKING:
    from .element_model import Element


class ContractBase(SQLModel):
		name: str
		start_date: str
		end_date: Optional[str]
		invoice_proposed: Optional[float]
		invoice_agreed: Optional[float]
		invoice_paid: Optional[float]
		created_at: datetime
		updated_at: Optional[datetime]
		deleted_at: Optional[datetime]


class Contract(ContractBase, table=True):
		__tablename__ = "contracts"

		id: int | None = Field(default=None, primary_key=True)

		elements: List["Element"] = Relationship(back_populates="contract")