from sqlalchemy import create_engine
from sqlalchemy.orm import sessionmaker
from src.config import settings
from src.services.sensor_service import insert_data
from src.utils.file_loader import load_sensor_data

engine = create_engine(str(settings.SQLALCHEMY_DATABASE_URI))
Session = sessionmaker(bind=engine)
session = Session()
def main():
    sensor_data = load_sensor_data("./sensors.json")

    if sensor_data:
        insert_data(sensor_data, session)
    else:
        print("No data to insert")

if __name__ == "__main__":
    main()