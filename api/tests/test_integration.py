import os
import json
import pytest
from src.main import main
from src.models.sensor_model import Sensor, SensorHistory
from src.services.sensor_service import insert_data
from src.schemas.sensor import ModelItem


@pytest.fixture(scope="module")
def db_session():
    from sqlalchemy import create_engine
    from sqlalchemy.orm import sessionmaker
    from src.models.sensor_model import Base

    # create a persistent sqlite database for integration tests
    engine = create_engine('sqlite:///test_integration.db')
    Base.metadata.create_all(engine)

    # create a database session
    Session = sessionmaker(bind=engine)
    session = Session()

    yield session

    session.close()
    # comment this line to retain tables in the integration database
    Base.metadata.drop_all(engine)


@pytest.fixture
def load_test_json():

    with open(os.path.join(os.path.dirname(__file__), 'resources', 'test_file_loader.json'), 'r') as file:
        return json.load(file)


def test_integration(db_session, load_test_json):
    # create and commit sensor entries
    sensor_1 = Sensor(id=101, entidad_vegetal=1, element_id=None, model="Model1", operative=True, class_type="ClassA")
    sensor_2 = Sensor(id=102, entidad_vegetal=2, element_id=None, model="Model2", operative=True, class_type="ClassB")

    db_session.add(sensor_1)
    db_session.add(sensor_2)
    db_session.commit()

    # convert the loaded JSON data to ModelItems
    mock_data = [ModelItem(**sensor) for sensor in load_test_json]

    # insert the data into the database
    insert_data(mock_data, db_session)

    # call the main function to process the data
    main()


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
