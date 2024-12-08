from sentry_sdk.crons import monitor

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
            print("No data to insert")
            return

        for sensor in sensor_file_data:
            sensor_model = SensorHistory.model_validate(sensor)
            session.add(sensor_model)
            session.commit()
            session.refresh(sensor_model)

    except Exception as e:
        print("Error", e)
        return
