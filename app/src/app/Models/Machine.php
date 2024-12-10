<?php

namespace App\Models;

class Machine extends BaseModel
{
    public ?string $name;

    public float $max_basket_size;

    public ?int $photo_id;

    protected static function getTableName(): string
    {
        return 'machines';
    }

    protected static function mapDataToModel($data): Machine
    {
        $machine = new self();
        $machine->id = $data['id'];
        $machine->name = $data['name'];
        $machine->max_basket_size = $data['max_basket_size'];
        $machine->photo_id = $data['photo_id'];
        $machine->created_at = $data['created_at'];
        $machine->updated_at = $data['updated_at'];
        $machine->deleted_at = $data['deleted_at'];

        return $machine;
    }

    public function photo(): ?Photo
    {
        return $this->photo_id ? $this->belongsTo(Photo::class, 'photo_id') : null;
    }
}
