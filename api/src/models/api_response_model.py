# Api success response:

from typing import List, TypeVar, Union


T = TypeVar("T")


class ApiResponse:
    status: str
    details: Union[T, List[T]]


class ErrorResponse:
    status: str
    message: str
    errors: Union[T, List[T]]
    code: int
