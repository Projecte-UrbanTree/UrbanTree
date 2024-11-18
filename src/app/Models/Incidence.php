<?php

namespace App\Models;

class Incidence extends BaseModel
{
    public int $element_id;

    public string $name;

    public ?string $description;

    public ?string $photo;

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
        $incidence->photo = $data['photo'];
        $incidence->created_at = $data['created_at'];

        return $incidence;
    }

    // Fetch the element of the incidence
    public function element(): Element
    {
        return $this->belongsTo(Element::class, 'element_id');
    }
}
