import pytest
from pydantic import ValidationError
from src.config import Settings


def test_settings_defaults():
    settings = Settings(
        MARIADB_SERVER="localhost",
        MARIADB_USER="user",
        MARIADB_PASSWORD="password",
        MARIADB_DB="test_db",
    )
    assert settings.APP_NAME is None
    assert settings.APP_PACKAGE == "api"
    assert settings.APP_ENV == "test"
    assert settings.IMAGE_VERSION is None
    assert settings.MARIADB_SERVER == "localhost"
    assert settings.MARIADB_PORT == 3306
    assert settings.MARIADB_USER == "user"
    assert settings.MARIADB_PASSWORD == "password"
    assert settings.MARIADB_PASSWORD_FILE is None
    assert settings.MARIADB_DB == "test_db"
    assert settings.SENTRY_DSN is None

    assert (
        str(settings.SQLALCHEMY_DATABASE_URI)
        == "mysql+pymysql://user:password@localhost:3306/test_db"
    )
    assert settings.SENTRY_RELEASE is None


def test_settings_missing_password():
    with pytest.raises(ValidationError):
        Settings(
            MARIADB_SERVER="localhost",
            MARIADB_USER="user",
            MARIADB_DB="test_db",
        )


def test_settings_with_password_file(tmp_path):
    password_file = tmp_path / "password.txt"
    password_file.write_text("file_password")

    settings = Settings(
        MARIADB_SERVER="localhost",
        MARIADB_USER="user",
        MARIADB_PASSWORD_FILE=str(password_file),
        MARIADB_DB="test_db",
    )
    assert settings.MARIADB_PASSWORD_FILE == "file_password"
    assert (
        str(settings.SQLALCHEMY_DATABASE_URI)
        == "mysql+pymysql://user:file_password@localhost:3306/test_db"
    )


def test_password_file_does_not_exist():
    with pytest.raises(
        ValueError, match="Password file /non/existent/path does not exist."
    ):
        Settings(
            MARIADB_SERVER="localhost",
            MARIADB_USER="user",
            MARIADB_PASSWORD_FILE="/non/existent/path",
            MARIADB_DB="test_db",
        )


def test_settings_with_both_password_and_password_file(tmp_path):
    password_file = tmp_path / "password.txt"
    password_file.write_text("file_password")

    settings = Settings(
        MARIADB_SERVER="localhost",
        MARIADB_USER="user",
        MARIADB_PASSWORD="password",
        MARIADB_PASSWORD_FILE=str(password_file),
        MARIADB_DB="test_db",
    )
    # MARIADB_PASSWORD should take precedence over MARIADB_PASSWORD_FILE
    assert settings.MARIADB_PASSWORD == "password"
    assert settings.MARIADB_PASSWORD_FILE == "file_password"
    assert (
        str(settings.SQLALCHEMY_DATABASE_URI)
        == "mysql+pymysql://user:password@localhost:3306/test_db"
    )


def test_settings_with_custom_port():
    settings = Settings(
        MARIADB_SERVER="localhost",
        MARIADB_PORT=3307,
        MARIADB_USER="user",
        MARIADB_PASSWORD="password",
        MARIADB_DB="test_db",
    )
    assert settings.MARIADB_PORT == 3307
    assert (
        str(settings.SQLALCHEMY_DATABASE_URI)
        == "mysql+pymysql://user:password@localhost:3307/test_db"
    )


def test_sentry_release_with_image_version():
    settings = Settings(
        IMAGE_VERSION="1.0.0",
        MARIADB_SERVER="localhost",
        MARIADB_USER="user",
        MARIADB_PASSWORD="password",
        MARIADB_DB="test_db",
    )
    assert settings.SENTRY_RELEASE == "api@1.0.0"


def test_sentry_release_without_image_version():
    settings = Settings(
        MARIADB_SERVER="localhost",
        MARIADB_USER="user",
        MARIADB_PASSWORD="password",
        MARIADB_DB="test_db",
    )
    assert settings.SENTRY_RELEASE is None
