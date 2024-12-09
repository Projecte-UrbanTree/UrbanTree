from sqlmodel import Session, SQLModel, create_engine

from .config import settings

engine = create_engine(str(settings.SQLALCHEMY_DATABASE_URI))


def create_db_and_tables(engine=engine):
    SQLModel.metadata.create_all(engine)


def drop_db_and_tables(engine=engine):
    SQLModel.metadata.drop_all(engine)


def get_session():
    with Session(engine) as session:
        return session
