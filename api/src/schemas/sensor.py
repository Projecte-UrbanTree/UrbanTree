from datetime import datetime
from typing import List, Optional

from pydantic import BaseModel, RootModel


class ModelItem(BaseModel):
    id: Optional[int]
    sensor_id: int
    temperature: float
    humidity: float
    inclination: float
    created_at: datetime


class Model(RootModel):
    root: List[ModelItem]
