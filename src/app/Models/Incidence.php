<?php

namespace App\Models;

class Incidence extends BaseModel
{
    public int $element_id;

    public string $name;

    public string $description;

    public ?string $photo;

    public static function mapDataToModel($data)
    {
        $incidence = new Incidence;
        $incidence->id = $data['id'];
        $incidence->element_id = $data['element_id'];
        $incidence->name = $data['name'];
        $incidence->description = $data['description'];
        $incidence->photo = $data['photo'];
        $incidence->created_at = $data['created_at'];

        return $incidence;
    }

    // Fetch the element of the incidence
    public function element()
    {
        return $this->belongsTo(Element::class, 'element_id');
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    protected static function getTableName()
    {
        return 'incidences';
    }
}
