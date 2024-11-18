<?php

namespace App\Models;

class MMachine extends BaseModel
{
    public ?string $name;
    public float $max_basket_size;

    protected static function getTableName(): string
    {
        return 'machines';
    }

    protected static function mapDataToModel($data): MMachine
    {
        $machine = new self();
        $machine->id = $data['id'];
        $machine->name = $data['name'];
        $machine->max_basket_size = $data['max_basket_size'];
        $machine->created_at = $data['created_at'];
        return $machine;
    }
}
