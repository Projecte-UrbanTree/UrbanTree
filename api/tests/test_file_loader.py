import pytest
from src.utils.file_loader import load_sensor_data

@pytest.fixture
def mock_json_data():
    json_file_path = 'tests/resources/test_file_loader.json'
    return json_file_path

# verify that the 'load_sensor_data' function loads the file as expected
def test_load_sensor_data(mock_json_data):
    result = load_sensor_data(mock_json_data)

    assert len(result) == 2
    assert result[0].id == 1
    assert result[1].sensor_id == 102
