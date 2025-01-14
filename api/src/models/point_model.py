from datetime import datetime
from typing import Optional, TYPE_CHECKING
from sqlmodel import Field, Relationship, SQLModel

if TYPE_CHECKING:
	from .element_model import Element
	from .zone_model import Zone

class PointBase(SQLModel):
		latitude: float
		longitude: float

		zone_id: Optional[int]
		element_id: Optional[int]

		created_at: datetime
		updated_at: Optional[datetime]
		deleted_at: Optional[datetime]

class Point(PointBase, table=True):
		__tablename__ = "points"

		id: int = Field(default=None, primary_key=True)

		element: Optional["Element"] = Relationship(back_populates="points")
		zone: Optional["Zone"] = Relationship(back_populates="points")

class PointCreate(PointBase):
		pass