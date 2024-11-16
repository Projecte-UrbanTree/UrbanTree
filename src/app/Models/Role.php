<?php

namespace App\Models;

use App\Core\BaseModel;

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
        return $role;
    }
}
