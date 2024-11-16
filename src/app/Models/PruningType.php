<?php

namespace App\Models;

use App\Core\BaseModel;
use App\Core\Database;

class PruningType extends BaseModel
{
    public string $name;
    public ?string $description;

    protected static function getTableName()
    {
        return 'pruning_types';
    }

    protected static function mapDataToModel($data)
    {
        $pruning_type = new PruningType();
        $pruning_type->id = $data['id'];
        $pruning_type->name = $data['name'];
        $pruning_type->description = $data['description'];
        return $pruning_type;
    }
}
