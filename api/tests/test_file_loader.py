import json

import pytest
from src.utils.file_loader import load_json_file


@pytest.fixture
def mock_json_data():
    return "tests/resources/test_file_loader.json"


@pytest.fixture
def mock_invalid_json_data():
    return "tests/resources/invalid_test_file_loader.json"


@pytest.fixture
def mock_nonexistent_file():
    return "tests/resources/nonexistent_file.json"


# verify that the 'load_sensor_data' function loads the file as expected
def test_load_sensor_data(mock_json_data):
    result = load_json_file(mock_json_data)

    assert len(result) == 2
    assert result[0]["id"] == 1
    assert result[1]["sensor_id"] == 102


# verify that the 'load_sensor_data' function raises an error for invalid JSON
def test_load_sensor_data_invalid_json(mock_invalid_json_data):
    with pytest.raises(json.JSONDecodeError):
        load_json_file(mock_invalid_json_data)


# verify that the 'load_sensor_data' function raises an error for nonexistent file
def test_load_sensor_data_nonexistent_file(mock_nonexistent_file):
    with pytest.raises(FileNotFoundError):
        load_json_file(mock_nonexistent_file)
