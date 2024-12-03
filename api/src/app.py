from fastapi import FastAPI
from sqlmodel import Session, SQLModel, create_engine
from src.config import settings
from src.services.sensor_service import insert_data
from src.utils.file_loader import load_sensor_data

engine = create_engine(str(settings.SQLALCHEMY_DATABASE_URI))

def create_db_and_tables():
    SQLModel.metadata.create_all(engine)


app = FastAPI()

@app.on_event("startup")
def on_startup():
    create_db_and_tables()
    sensor_data = load_sensor_data("./sensors.json")
    with Session(engine) as session:
        if sensor_data:
            insert_data(sensor_data, session)
        else:
            print("No data to insert")

@app.get("/")
def hello():
    return "Hello, Docker!"
