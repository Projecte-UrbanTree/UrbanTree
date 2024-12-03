from typing import List
from src.schemas.sensor import ModelItem
from src.models.sensor_model import Sensor, SensorHistory
from sqlalchemy.orm import Session
from datetime import datetime


def insert_data(sensor_data: List[ModelItem], session: Session):
    try:
        for sensor in sensor_data:
            # Search existent sensor
            db_sensor = session.query(Sensor).filter_by(id=sensor.sensor_id).first()

            if db_sensor:
                db_history = SensorHistory(
                    sensor_id=sensor.sensor_id,
                    temperature=sensor.temperature,
                    humidity=sensor.humidity,
                    inclination=sensor.inclination,
                    created_at=sensor.created_at
                )
                session.add(db_history)

        session.commit()
        print("Datos insertados correctamente 👍🏼")
    except Exception as e:
        session.rollback()
        print(f"Error al insertar los datos: {e}")
