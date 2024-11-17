<?php

namespace App\Models;

use App\Core\BaseModel;

class MRole extends BaseModel
{
    public $name;

    protected static function getTableName()
    {
        return 'roles';
    }

    protected static function mapDataToModel($data)
    {
        $role = new MRole();
        $role->id = $data['id'];
        $role->name = $data['name'];
        $role->created_at = $data['created_at'];
        return $role;
    }
}
