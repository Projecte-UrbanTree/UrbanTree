import json


def load_json_file(file_path: str) -> json:
    try:
        with open(file_path, "r") as f:
            return json.load(f)
    except Exception as e:
        raise e
