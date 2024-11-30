import os

from typing import Any

from pydantic import (
    MariaDBDsn,
    computed_field,
    validator,
    field_validator,
    model_validator,
)
from pydantic_core import MultiHostUrl
from pydantic_settings import BaseSettings, SettingsConfigDict


class Settings(BaseSettings):
    model_config = SettingsConfigDict(secrets_dir='/run/secrets')

    MARIADB_SERVER: str
    MARIADB_PORT: int = 3306
    MARIADB_USER: str
    MARIADB_PASSWORD: str | None = None
    MARIADB_PASSWORD_FILE: str | None = None
    MARIADB_DB: str

    @model_validator(mode="before")
    @classmethod
    def check_mariadb_password(cls, data: Any) -> Any:
        if isinstance(data, dict):
            if data.get("MARIADB_PASSWORD_FILE") is None and data.get("MARIADB_PASSWORD") is None:
                raise ValueError("At least one of MARIADB_PASSWORD_FILE and MARIADB_PASSWORD must be set.")
        return data

    # @validator('MARIADB_PASSWORD_FILE', pre=True, always=True)
    @field_validator("MARIADB_PASSWORD_FILE")
    def read_password_from_file(cls, v):
        if v is not None:
            file_path = v
            if os.path.exists(file_path):
                with open(file_path, 'r') as file:
                    return file.read().strip()
            raise ValueError(f"Password file {file_path} does not exist.")
        return v

    @computed_field
    @property
    def SQLALCHEMY_DATABASE_URI(self) -> MariaDBDsn:
        return MultiHostUrl.build(
            scheme="mysql+pymysql",
            username=self.MARIADB_USER,
            password=self.MARIADB_PASSWORD if self.MARIADB_PASSWORD else self.MARIADB_PASSWORD_FILE,
            host=self.MARIADB_SERVER,
            port=self.MARIADB_PORT,
            path=self.MARIADB_DB,
        )

settings = Settings()