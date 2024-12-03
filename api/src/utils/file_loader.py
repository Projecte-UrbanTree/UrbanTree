import json
from typing import List
from src.schemas.sensor import ModelItem

def load_sensor_data(file_path: str) -> List[ModelItem]:
    try:
        with open(file_path, "r") as f:
            raw_data = json.load(f)
            # raw_data: List[dict]

        return [ModelItem(**sensor) for sensor in raw_data]
    except Exception as e:
        print('Error', e)
        return []
