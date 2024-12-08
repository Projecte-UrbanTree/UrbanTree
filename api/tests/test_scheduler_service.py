from datetime import timedelta

from apscheduler.triggers.interval import IntervalTrigger
from src.services.scheduler_service import scheduler
from src.services.sensor_service import check_sensor_task


def test_scheduler_job_added():
    jobs = scheduler.get_jobs()
    assert len(jobs) == 1
    job = jobs[0]
    assert job.func == check_sensor_task
    assert isinstance(job.trigger, IntervalTrigger)
    assert job.trigger.interval == timedelta(hours=8)


def test_scheduler_start():
    scheduler.start()
    assert scheduler.running


def test_scheduler_shutdown():
    scheduler.shutdown()
    assert not scheduler.running
