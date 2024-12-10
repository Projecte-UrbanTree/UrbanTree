<?php

namespace App\Models;

class ElementType extends BaseModel
{
    public string $name;

    public string $description;

    protected static function getTableName(): string
    {
        return 'element_types';
    }

    protected static function mapDataToModel($data): ElementType
    {
        $elementType = new self();
        $elementType->id = $data['id'];
        $elementType->name = $data['name'];
        $elementType->description = $data['description'];
        $elementType->created_at = $data['created_at'];

        return $elementType;
    }

    //public function element(): Element
    //{
    //    return $this->belongsTo(Element::class, 'element_id');
    //}

}
