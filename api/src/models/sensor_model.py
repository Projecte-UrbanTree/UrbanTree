from sqlalchemy import (
    TIMESTAMP,
    Boolean,
    Column,
    Float,
    ForeignKey,
    Integer,
    String,
    func,
)
from sqlalchemy.orm import declarative_base, relationship

Base = declarative_base()


class Sensor(Base):
    __tablename__ = "sensors"

    id = Column(Integer, primary_key=True, autoincrement=True)
    model = Column(String(255), nullable=True)
    is_active = Column(Boolean, nullable=True)
    created_at = Column(TIMESTAMP, default=func.current_timestamp())

    histories = relationship("SensorHistory", back_populates="sensor")

    def __repr__(self):
        return (
            f"<Sensor(id={self.id}, model='{self.model}', "
            f"is_active={self.is_active}, created_at={self.created_at})>"
        )


class SensorHistory(Base):
    __tablename__ = "sensor_history"

    id = Column(Integer, primary_key=True, autoincrement=True)
    sensor_id = Column(Integer, ForeignKey("sensors.id"), nullable=False)
    temperature = Column(Float, nullable=True)
    humidity = Column(Float, nullable=True)
    inclination = Column(Float, nullable=True)
    created_at = Column(TIMESTAMP, default=func.current_timestamp())

    sensor = relationship("Sensor", back_populates="histories")

    def __repr__(self):
        return (
            f"<SensorHistory(id={self.id}, sensor_id={self.sensor_id}, "
            f"temperature={self.temperature}, humidity={self.humidity}, "
            f"inclination={self.inclination}, created_at={self.created_at})>"
        )
