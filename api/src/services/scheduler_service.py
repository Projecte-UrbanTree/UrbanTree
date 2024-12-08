from datetime import datetime

from apscheduler.schedulers.background import BackgroundScheduler
from apscheduler.triggers.interval import IntervalTrigger

from .sensor_service import check_sensor_task

trigger8h = IntervalTrigger(hours=8)

now = datetime.now()

scheduler = BackgroundScheduler()
scheduler.add_job(check_sensor_task, trigger8h, next_run_time=now)
