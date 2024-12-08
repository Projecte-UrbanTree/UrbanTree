import pytest
from dotenv import load_dotenv
from pydantic import ValidationError

load_dotenv("tests/resources/.env.test", override=True)
from src.config import Settings, settings  # noqa: E402


def test_settings_defaults():
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


def test_settings_with_custom_settings():
    custom = Settings(
        APP_NAME="api",
        APP_PACKAGE="api2",
        APP_ENV="production",
        IMAGE_VERSION="1.0.0",
        MARIADB_SERVER="127.0.0.1",
        MARIADB_PORT=3307,
        MARIADB_USER="user2",
        MARIADB_PASSWORD="password2",
        MARIADB_DB="test_db2",
        SENTRY_DSN="https://test.sentry.io",
    )
    assert custom.APP_NAME == "api"
    assert custom.APP_PACKAGE == "api2"
    assert custom.APP_ENV == "production"
    assert custom.IMAGE_VERSION == "1.0.0"
    assert custom.MARIADB_SERVER == "127.0.0.1"
    assert custom.MARIADB_PORT == 3307
    assert custom.MARIADB_USER == "user2"
    assert custom.MARIADB_PASSWORD == "password2"
    assert custom.MARIADB_DB == "test_db2"
    assert custom.SENTRY_DSN == "https://test.sentry.io"
    assert (
        str(custom.SQLALCHEMY_DATABASE_URI)
        == "mysql+pymysql://user2:password2@127.0.0.1:3307/test_db2"
    )
    assert custom.SENTRY_RELEASE == "api2@1.0.0"


def test_v_prefixed_image_version():
    custom = Settings(
        APP_ENV="production",
        IMAGE_VERSION="v1.0.0",
    )
    assert custom.IMAGE_VERSION == "1.0.0"
    assert custom.SENTRY_RELEASE == "api@1.0.0"


def test_settings_missing_password():
    with pytest.raises(ValidationError):
        Settings(
            MARIADB_PASSWORD=None,
            MARIADB_PASSWORD_FILE=None,
        )


def test_settings_with_password_file(tmp_path):
    password_file = tmp_path / "password.txt"
    password_file.write_text("file_password")

    custom_settings = Settings(
        MARIADB_PASSWORD=None,
        MARIADB_PASSWORD_FILE=str(password_file),
    )
    assert custom_settings.MARIADB_PASSWORD_FILE == "file_password"
    assert (
        str(custom_settings.SQLALCHEMY_DATABASE_URI)
        == "mysql+pymysql://user:file_password@localhost:3306/test_db"
    )


def test_password_file_does_not_exist():
    with pytest.raises(
        ValueError, match="Password file /non/existent/path does not exist."
    ):
        Settings(
            MARIADB_PASSWORD_FILE="/non/existent/path",
        )


def test_settings_with_both_password_and_password_file(tmp_path):
    password_file = tmp_path / "password.txt"
    password_file.write_text("file_password")

    custom_settings = Settings(
        MARIADB_PASSWORD="password",
        MARIADB_PASSWORD_FILE=str(password_file),
    )
    # MARIADB_PASSWORD should take precedence over MARIADB_PASSWORD_FILE
    assert custom_settings.MARIADB_PASSWORD == "password"
    assert custom_settings.MARIADB_PASSWORD_FILE == "file_password"
    assert (
        str(custom_settings.SQLALCHEMY_DATABASE_URI)
        == "mysql+pymysql://user:password@localhost:3306/test_db"
    )
