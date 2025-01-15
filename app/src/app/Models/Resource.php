<?php

namespace App\Models;

use App\Models;

class Resource extends BaseModel
{
    public string $name;
    public int $resource_type_id;
    public ?string $description;

    protected static function getTableName(): string
    {
        return 'resources';
    }

    protected static function mapDataToModel($data): Resource
    {
        $resource = new self();
        $resource->id = $data['id'];
        $resource->name = $data['name'];
        $resource->description = $data['description'];
        $resource->resource_type_id = $data['resource_type_id'];
        $resource->created_at = $data['created_at'];
        $resource->updated_at = $data['updated_at'];
        $resource->deleted_at = $data['deleted_at'];

        return $resource;
    }

    public function resourceType()
    {
        return $this->belongsTo(ResourceType::class, 'resource_type_id');
    }
}
