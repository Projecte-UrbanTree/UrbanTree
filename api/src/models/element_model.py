from datetime import datetime
from typing import TYPE_CHECKING, Optional

from sqlmodel import Field, Relationship, SQLModel

if TYPE_CHECKING:
		from .contract_model import Contract
		from .zone_model import Zone
		from .point_model import Point
		from .tree_type_model import TreeType
		from .element_type_model import ElementType

class ElementBase(SQLModel):
		element_type_id: int
		contract_id: int
		zone_id: int
		point_id: int
		tree_type_id: Optional[int]
		description: Optional[str]
		created_at: datetime
		updated_at: Optional[datetime]
		deleted_at: Optional[datetime]

class Element(ElementBase, table=True):
		__tablename__ = "elements"

		id: int | None = Field(default=None, primary_key=True)

		element_type: "ElementType" = Relationship(back_populates="elements")
		contract: "Contract" = Relationship(back_populates="elements")
		zone: "Zone" = Relationship(back_populates="elements")
		point: "Point" = Relationship(back_populates="elements")
		tree_type: "TreeType" = Relationship(back_populates="elements")

class ElementCreate(ElementBase):
		pass
