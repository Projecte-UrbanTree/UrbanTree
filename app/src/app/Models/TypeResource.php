<?php
namespace App\Models;

class TypeResource extends BaseModel
{

    public string $category;
    public string $description;

    protected static function getTableName(): string
    {
        return 'type_resources';
    }

    protected static function mapDataToModel($data): self
    {
        $type_resource = new self();
        $type_resource->id = $data['id'];
        $type_resource->category = $data['category'];
        $type_resource->description = $data['description'];
        $type_resource->created_at = $data['created_at'];
        $type_resource->updated_at = $data['updated_at'];
        $type_resource->deleted_at = $data['deleted_at'];

        return $type_resource;
    }
}