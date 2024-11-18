<?php

namespace App\Models;

class MSensorHistory extends BaseModel
{
    public int $sensor_id;
    public ?float $temperature;
    public ?int $humidity;
    public ?int $inclination;

    protected static function getTableName(): string
    {
        return 'sensor_history';
    }

    protected static function mapDataToModel($data): MSensorHistory
    {
        $sensor_history = new self();
        $sensor_history->sensor_id = $data['sensor_id'];
        $sensor_history->temperature = $data['temperature'];
        $sensor_history->humidity = $data['humidity'];
        $sensor_history->inclination = $data['inclination'];
        $sensor_history->created_at = $data['created_at'];
        return $sensor_history;
    }

    public function sensor(): MSensor
    {
        return $this->belongsTo(MSensor::class, 'sensor_id');
    }
}
