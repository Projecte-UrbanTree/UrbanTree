<?php

namespace App\Models;

class Photo extends BaseModel
{
    public string $name;

    public string $path;

    protected static function getTableName(): string
    {
        return 'photos';
    }

    protected static function mapDataToModel($data): Photo
    {
        $photo = new self();
        $photo->id = $data['id'];
        $photo->name = $data['name'];
        $photo->path = $data['path'];
        $photo->created_at = $data['created_at'];

        return $photo;
    }
}
