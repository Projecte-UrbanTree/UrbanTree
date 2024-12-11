<?php

namespace App\Models;

class Incidence extends BaseModel
{
    public int $element_id;

    public string $name;

    public ?string $description;

    public ?int $photo_id;

    protected static function getTableName(): string
    {
        return 'incidences';
    }

    public static function mapDataToModel($data): Incidence
    {
        $incidence = new self();
        $incidence->id = $data['id'];
        $incidence->element_id = $data['element_id'];
        $incidence->name = $data['name'];
        $incidence->description = $data['description'];
        $incidence->photo_id = $data['photo_id'];
        $incidence->created_at = $data['created_at'];
        $incidence->updated_at = $data['updated_at'];
        $incidence->deleted_at = $data['deleted_at'];

        return $incidence;
    }

    public function element(): Element
    {
        return $this->belongsTo(Element::class, 'element_id');
    }

    public function photo(): ?Photo
    {
        return $this->photo_id ? $this->belongsTo(Photo::class, 'photo_id') : null;
    }
}
