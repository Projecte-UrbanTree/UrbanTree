# Api success response:

from enum import Enum
from typing import Generic, List, TypeVar, Union

from pydantic import BaseModel

T = TypeVar("T")


class ApiResponse(BaseModel, Generic[T]):
    status: str = "success"
    details: Union[T, List[T], None] = None


class ErrorResponse(BaseModel):
    status: str = "error"
    message: str
    errors: Union[T, List[T], None] = None
    code: int
