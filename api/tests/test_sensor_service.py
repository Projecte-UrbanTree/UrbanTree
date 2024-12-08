import pytest
from sqlalchemy.orm import sessionmaker
from src.models import Sensor, SensorHistory, SensorHistoryCreate


# fixture for the in-memory database
@pytest.fixture
def db_session():
    from src.database import create_db_and_tables, create_engine, drop_db_and_tables

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


# test to insert data
def test_insert_data(db_session):
    # insert sensors into the database before inserting history
    sensor_1 = Sensor(
        id=101, contract_id=1, zone_id=1, point_id=1, model="Model1", is_active=True
    )
    sensor_2 = Sensor(
        id=102, contract_id=2, zone_id=2, point_id=2, model="Model2", is_active=True
    )

    db_session.add(sensor_1)
    db_session.add(sensor_2)
    db_session.commit()

    # verify that the sensors were inserted correctly into the database
    sensor_records = db_session.query(Sensor).all()
    assert len(sensor_records) == 2  # verify that 2 sensors were inserted

    # mock data including 'sensor_id' and other fields
    mock_data = [
        SensorHistoryCreate(
            id=1,
            sensor_id=101,
            temperature=23.5,
            humidity=45.2,
            inclination=0.15,
            created_at="2024-11-17T10:30:00",
        ),
        SensorHistoryCreate(
            id=2,
            sensor_id=102,
            temperature=25.3,
            humidity=40.8,
            inclination=0.30,
            created_at="2024-11-17T11:00:00",
        ),
    ]

    # insert mock data into the database
    for data in mock_data:
        sensor_model = SensorHistory.model_validate(data)
        db_session.add(sensor_model)
        db_session.commit()

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

    # verify that records have been inserted into Sensor
    sensor_records = db_session.query(Sensor).all()

    assert len(sensor_records) == 2
    assert sensor_records[0].id == 101
    assert sensor_records[1].id == 102
