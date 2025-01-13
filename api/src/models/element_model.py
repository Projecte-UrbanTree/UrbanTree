from typing import TYPE_CHECKING

from sqlmodel import Field, Relationship, SQLModel

if TYPE_CHECKING:
		from .contract_model import Contract
		from .zone_model import Zone
		from .point_model import Point
		from .tree_type_model import TreeType
		from .element_type_model import ElementType

class Element(SQLModel, table=True):
		__tablename__ = "elements"

		id: int | None = Field(default=None, primary_key=True)

		zone_id: int = Field(index=True)
		point_id: int = Field(index=True)
		tree_type_id: int = Field(index=True)
		element_type_id: int = Field(index=True)
		name: str
		description: str
		created_at: str
		is_active: bool

		zone: "Zone" = Relationship(back_populates="elements")
		point: "Point" = Relationship(back_populates="elements")
		tree_type: "TreeType" = Relationship(back_populates="elements")
		element_type: "ElementType" = Relationship(back_populates="elements")

		contract_id: int = Field(index=True)
		contract: "Contract" = Relationship(back_populates="elements")