import pytest
from sqlalchemy import create_engine
from sqlalchemy.orm import sessionmaker
from src.schemas.sensor import ModelItem
from src.services.sensor_service import insert_data
from src.models.sensor_model import Base, Sensor, SensorHistory


# fixture for the in-memory database
@pytest.fixture
def db_session():
    # create in-memory database
    engine = create_engine('sqlite:///:memory:')
    # create all tables (sensor, sensorhistory)
    Base.metadata.create_all(engine)

    # create session
    Session = sessionmaker(bind=engine)
    session = Session()

    # return the session to be used in tests
    yield session

    # close the session and drop tables after the test
    session.close()
    Base.metadata.drop_all(engine)


# test to insert data
def test_insert_data(db_session):
    # insert sensors into the database before inserting history
    sensor_1 = Sensor(id=101, entidad_vegetal=1, element_id=None, model="Model1", operative=True, class_type="ClassA")
    sensor_2 = Sensor(id=102, entidad_vegetal=2, element_id=None, model="Model2", operative=True, class_type="ClassB")

    db_session.add(sensor_1)
    db_session.add(sensor_2)
    db_session.commit()

    # verify that the sensors were inserted correctly into the database
    sensor_records = db_session.query(Sensor).all()
    assert len(sensor_records) == 2  # verify that 2 sensors were inserted

    # mock data including 'sensor_id' and other fields
    mock_data = [
        ModelItem(id=1, sensor_id=101, temperature=23.5, humedad=45.2, inclination=0.15, created_at="2024-11-17T10:30:00"),
        ModelItem(id=2, sensor_id=102, temperature=25.3, humedad=40.8, inclination=0.30, created_at="2024-11-17T11:00:00")
    ]

    # call the data insertion function passing the database session
    insert_data(mock_data, db_session)

    # verify that records have been inserted into SensorHistory
    history_records = db_session.query(SensorHistory).all()

    assert len(history_records) == 2  # verify that 2 records were inserted into SensorHistory

    # verify that history records are correctly associated
    assert history_records[0].sensor_id == 101
    assert history_records[1].sensor_id == 102
    assert history_records[0].temperature == 23.5
    assert history_records[1].temperature == 25.3

    # verify that records have been inserted into Sensor
    sensor_records = db_session.query(Sensor).all()

    assert len(sensor_records) == 2
    assert sensor_records[0].id == 101
    assert sensor_records[1].id == 102
