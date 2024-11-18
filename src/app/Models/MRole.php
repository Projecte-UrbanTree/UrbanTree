<?php

namespace App\Models;

class MRole extends BaseModel
{
    public string $name;

    protected static function getTableName(): string
    {
        return 'roles';
    }

    protected static function mapDataToModel($data): MRole
    {
        $role = new self();
        $role->id = $data['id'];
        $role->name = $data['name'];
        $role->created_at = $data['created_at'];
        return $role;
    }
}
