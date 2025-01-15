<?php
namespace App\Models;

use App\Models;

class Resource extends BaseModel
{
    public string $name;
    public int $type_resource_id;
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
        $resource->type_resource_id = $data['type_resource_id'];
        $resource->created_at = $data['created_at'];
        $resource->updated_at = $data['updated_at'];
        $resource->deleted_at = $data['deleted_at'];

        return $resource;
    }

    public function typeResource()
    {
        return $this->belongsTo(TypeResource::class, 'type_resource_id');
    }
}