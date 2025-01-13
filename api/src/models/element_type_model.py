from datetime import datetime
from typing import Optional
from sqlmodel import Field, SQLModel


class ElementTypeBase(SQLModel):
    name: str = Field(..., max_length=255)
    description: Optional[str] = Field(default=None, max_length=255)
    requires_tree_type: bool = Field(default=False, nullable=False)
    icon: Optional[str] = Field(default=None, max_length=255)
    color: Optional[str] = Field(default=None, max_length=7)
    created_at: datetime
    updated_at: Optional[datetime]
    deleted_at: Optional[datetime]


class ElementType(ElementTypeBase, table=True):
    __tablename__ = "element_types"

    id: int | None = Field(default=None, primary_key=True)


class ElementTypeCreate(ElementTypeBase):
    pass
