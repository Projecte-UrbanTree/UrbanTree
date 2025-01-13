from datetime import datetime
from sqlmodel import Field, Relationship, SQLModel
from typing import TYPE_CHECKING, Optional

if TYPE_CHECKING:
		from .photo_model import Photo

class UserBase(SQLModel):
		company: Optional[str]
		name: str
		surname: str
		dni: str
		password: str
		email: str
		role: int
		created_at: datetime
		updated_at: Optional[datetime]
		deleted_at: Optional[datetime]

		photo_id: Optional[int] = Field(foreign_key="photos.id")

class User(UserBase, table=True):
		__tablename__ = "users"

		id: int | None = Field(default=None, primary_key=True)

		photos: Optional["Photo"] = Relationship(back_populates="users")

class UserCreate(UserBase):
		pass
