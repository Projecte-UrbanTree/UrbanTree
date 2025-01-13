from typing import TYPE_CHECKING

from sqlmodel import Field, Relationship, SQLModel

if TYPE_CHECKING:
    from .element_model import Element

class Contract(SQLModel, table=True):
		__tablename__ = "contracts"

		id: int | None = Field(default=None, primary_key=True)

		name: str
		description: str
		start_date: str
		end_date: str
		is_active: bool

		elements: list["Element"] = Relationship(back_populates="contract")