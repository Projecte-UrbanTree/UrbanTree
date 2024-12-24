from datetime import datetime
from typing import Generic, List, Optional, TypeVar, Union

from pydantic import BaseModel
from sqlmodel import Field, Relationship, SQLModel


class Sensor(SQLModel, table=True):
    __tablename__ = "sensors"

    id: int | None = Field(default=None, primary_key=True)

    contract_id: int = Field(index=True)
    zone_id: int = Field(index=True)
    point_id: int = Field(index=True)
    model: str | None = Field(default=None, index=True)
    is_active: bool | None = Field(default=None, index=True)

    histories: List["SensorHistory"] = Relationship(back_populates="sensor")


class SensorHistoryBase(SQLModel):
    temperature: float
    humidity: float
    inclination: float
    created_at: datetime

    sensor_id: int = Field(foreign_key="sensors.id")


class SensorHistory(SensorHistoryBase, table=True):
    __tablename__ = "sensor_history"

    id: int | None = Field(default=None, primary_key=True)

    sensor: Sensor = Relationship(back_populates="histories")


class SensorHistoryCreate(SensorHistoryBase):
    pass


class User(SQLModel, table=True):
    __tablename__ = "users"

    id: int | None = Field(default=None, primary_key=True)
    company: Optional[str] = Field(default=None, max_length=255)
    name: str = Field(max_length=255)
    surname: str = Field(max_length=255)
    dni: Optional[str] = Field(default=None, max_length=255, unique=True)
    password: str = Field(max_length=255)
    email: str = Field(max_length=255)
    role: int = Field()  # 0: customer, 1: worker, 2: admin
    photo_id: Optional[int] = Field(default=None, foreign_key="photos.id")
    created_at: Optional[datetime] = Field(default_factory=datetime.utcnow)
    updated_at: Optional[datetime] = Field(default=None)
    deleted_at: Optional[datetime] = Field(default=None)

    class Config:
        orm_mode = True


class UserResponse(BaseModel):
    id: int
    company: Optional[str] = None
    name: str
    surname: str
    dni: Optional[str] = None
    email: str
    role: int  # 0: customer, 1: worker, 2: admin
    photo_id: Optional[int] = None

    class Config:
        orm_mode = True


T = TypeVar("T")


class ApiResponse(BaseModel, Generic[T]):
    status: str  # 'success' o 'error'
    details: Union[T, List[T]]  # response details
    message: str
    status_code: int  # status code

    class Config:
        orm_mode = True
