<?php

namespace App\Models;

class Route extends BaseModel
{
    public ?float $distance;

    public ?int $travel_time;

    protected static function getTableName(): string
    {
        return 'routes';
    }

    protected static function mapDataToModel($data): Route
    {
        $route = new self;
        $route->id = $data['id'];
        $route->distance = $data['distance'];
        $route->travel_time = $data['travel_time'];
        $route->created_at = $data['created_at'];
        $route->updated_at = $data['updated_at'];
        $route->deleted_at = $data['deleted_at'];

        return $route;
    }

    public function points(): ?array
    {
        return $this->belongsToMany(Point::class, 'route_points', 'route_id', 'point_id', 'id', 'id', true);
    }
}
