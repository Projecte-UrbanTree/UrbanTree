from sentry_sdk.crons import monitor
from sqlmodel import select

from src.database import get_session
from src.models import SensorHistory
from src.utils.file_loader import load_json_file


# Define a cron job to check the sensors
@monitor(monitor_slug="check-sensors")
def check_sensor_task():
    try:
        sensor_file_data = load_json_file("sensors.json")
        session = get_session()

        if not sensor_file_data:
            raise ValueError("No data to insert")

        for sensor_history_entry in sensor_file_data:
            sensor_history = SensorHistory.model_validate(sensor_history_entry)
            statement = select(SensorHistory).where(
                SensorHistory.sensor_id == sensor_history.sensor_id,
                SensorHistory.created_at == sensor_history.created_at,
            )
            sensor_db = session.exec(statement).first()
            if sensor_db:
                sensor_db.temperature = sensor_history.temperature
                sensor_db.humidity = sensor_history.humidity
                sensor_db.inclination = sensor_history.inclination
                session.add(sensor_db)
            else:
                session.add(sensor_history)
            session.commit()

    except Exception as e:
        session.rollback()
        raise e
