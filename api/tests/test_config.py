import pytest
from pydantic import ValidationError
from src.config import Settings


def test_settings_with_password():
    settings = Settings(
        MARIADB_SERVER="localhost",
        MARIADB_USER="user",
        MARIADB_PASSWORD="password",
        MARIADB_DB="test_db",
        SENTRY_DSN="http://example.com",
    )
    assert settings.MARIADB_PASSWORD == "password"
    assert (
        str(settings.SQLALCHEMY_DATABASE_URI)
        == "mysql+pymysql://user:password@localhost:3306/test_db"
    )


def test_settings_with_password_file(tmp_path):
    password_file = tmp_path / "password.txt"
    password_file.write_text("file_password")

    settings = Settings(
        MARIADB_SERVER="localhost",
        MARIADB_USER="user",
        MARIADB_PASSWORD_FILE=str(password_file),
        MARIADB_DB="test_db",
        SENTRY_DSN="http://example.com",
    )
    assert settings.MARIADB_PASSWORD_FILE == "file_password"
    assert (
        str(settings.SQLALCHEMY_DATABASE_URI)
        == "mysql+pymysql://user:file_password@localhost:3306/test_db"
    )


def test_settings_missing_password():
    with pytest.raises(ValidationError):
        Settings(
            MARIADB_SERVER="localhost",
            MARIADB_USER="user",
            MARIADB_DB="test_db",
            SENTRY_DSN="http://example.com",
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
            SENTRY_DSN="http://example.com",
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
        SENTRY_DSN="http://example.com",
    )
    # MARIADB_PASSWORD should take precedence over MARIADB_PASSWORD_FILE
    assert settings.MARIADB_PASSWORD == "password"
    assert settings.MARIADB_PASSWORD_FILE == "file_password"
    assert (
        str(settings.SQLALCHEMY_DATABASE_URI)
        == "mysql+pymysql://user:password@localhost:3306/test_db"
    )


def test_settings_with_default_port():
    settings = Settings(
        MARIADB_SERVER="localhost",
        MARIADB_USER="user",
        MARIADB_PASSWORD="password",
        MARIADB_DB="test_db",
        SENTRY_DSN="http://example.com",
    )
    assert settings.MARIADB_PORT == 3306
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
        SENTRY_DSN="http://example.com",
    )
    assert settings.MARIADB_PORT == 3307
    assert (
        str(settings.SQLALCHEMY_DATABASE_URI)
        == "mysql+pymysql://user:password@localhost:3307/test_db"
    )
