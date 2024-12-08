from unittest.mock import patch

import pytest
from sqlalchemy.orm import sessionmaker
from src.database import create_db_and_tables, create_engine, drop_db_and_tables
from src.models import Sensor, SensorHistory, SensorHistoryCreate
from src.services.sensor_service import check_sensor_task


# fixture for the in-memory database
@pytest.fixture
def db_session():

    # create in-memory database
    engine = create_engine("sqlite:///:memory:")
    # create all tables (sensor, sensorhistory)
    create_db_and_tables(engine)

    # create session
    Session = sessionmaker(bind=engine)
    session = Session()

    # return the session to be used in tests
    yield session

    # close the session and drop tables after the test
    session.close()
    drop_db_and_tables(engine)


# test to check sensor task
@patch("src.services.sensor_service.load_json_file")
@patch("src.services.sensor_service.get_session")
def test_check_sensor_task(mock_get_session, mock_load_json_file, db_session):
    # mock the load_json_file function to return test data
    mock_load_json_file.return_value = [
        {
            "id": 1,
            "sensor_id": 101,
            "temperature": 23.5,
            "humidity": 45.2,
            "inclination": 0.15,
            "created_at": "2024-11-17T10:30:00",
        },
        {
            "id": 2,
            "sensor_id": 102,
            "temperature": 25.3,
            "humidity": 40.8,
            "inclination": 0.30,
            "created_at": "2024-11-17T11:00:00",
        },
    ]

    # mock the get_session function to return the db_session
    mock_get_session.return_value = db_session

    # call the check_sensor_task function
    check_sensor_task()

    # verify that records have been inserted into SensorHistory
    history_records = db_session.query(SensorHistory).all()

    assert (
        len(history_records) == 2
    )  # verify that 2 records were inserted into SensorHistory

    # verify that history records are correctly associated
    assert history_records[0].sensor_id == 101
    assert history_records[1].sensor_id == 102
    assert history_records[0].temperature == 23.5
    assert history_records[1].temperature == 25.3
