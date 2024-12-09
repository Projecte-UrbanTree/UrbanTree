import os

import pytest
from src.models import Sensor, SensorHistory, SensorHistoryCreate
from src.utils.file_loader import load_json_file


@pytest.fixture(scope="module")
def db_session():
    from sqlalchemy.orm import sessionmaker
    from src.database import create_db_and_tables, create_engine, drop_db_and_tables

    # create a persistent sqlite database for integration tests
    engine = create_engine("sqlite:///test_integration.db")
    create_db_and_tables(engine)

    # create a database session
    Session = sessionmaker(bind=engine)
    session = Session()

    yield session

    session.close()
    # comment this line to retain tables in the integration database
    drop_db_and_tables(engine)


@pytest.fixture
def load_test_json():
    path = os.path.join(os.path.dirname(__file__), "resources", "test_file_loader.json")
    return load_json_file(path)


def test_integration(db_session, load_test_json):
    # create and commit sensor entries
    sensor_1 = Sensor(
        id=101, contract_id=1, zone_id=1, point_id=1, model="Model1", is_active=True
    )
    sensor_2 = Sensor(
        id=102, contract_id=2, zone_id=2, point_id=2, model="Model2", is_active=True
    )

    db_session.add(sensor_1)
    db_session.add(sensor_2)
    db_session.commit()

    # validate and insert sensor history
    for sensor in load_test_json:
        sensor_model = SensorHistory.model_validate(sensor)
        db_session.add(sensor_model)
        db_session.commit()

    history_records = db_session.query(SensorHistory).all()
    assert len(history_records) == 2

    assert history_records[0].sensor_id == 101
    assert history_records[1].sensor_id == 102
    assert history_records[0].temperature == 23.5
    assert history_records[1].temperature == 25.3

    sensor_records = db_session.query(Sensor).all()
    assert len(sensor_records) == 2
    assert sensor_records[0].id == 101
    assert sensor_records[1].id == 102

    assert sensor_records[0].id == history_records[0].sensor_id
    assert sensor_records[1].id == history_records[1].sensor_id
