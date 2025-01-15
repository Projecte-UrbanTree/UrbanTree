<?php

namespace App\Models;

class ResourceType extends BaseModel
{

    public string $name;
    public string $description;

    protected static function getTableName(): string
    {
        return 'resource_type';
    }

    protected static function mapDataToModel($data): self
    {
        $resource_type = new self();
        $resource_type->id = $data['id'];
        $resource_type->name = $data['name'];
        $resource_type->description = $data['description'];
        $resource_type->created_at = $data['created_at'];
        $resource_type->updated_at = $data['updated_at'];
        $resource_type->deleted_at = $data['deleted_at'];

        return $resource_type;
    }
}
