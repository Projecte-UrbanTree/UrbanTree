<?php

namespace App\Models;

class Role extends BaseModel
{
    public $name;

    protected static function getTableName()
    {
        return 'roles';
    }

    protected static function mapDataToModel($data)
    {
        $role = new Role();
        $role->id = $data['id'];
        $role->name = $data['name'];
        $role->created_at = $data['created_at'];

        return $role;
    }
}
