<?php

namespace App\Models;

class ElementType extends BaseModel
{
    public string $name;

    public string $description;

    public bool $requires_tree_type;

    protected static function getTableName(): string
    {
        return 'element_types';
    }

    protected static function mapDataToModel($data): ElementType
    {
        $element_type = new self();
        $element_type->id = $data['id'];
        $element_type->name = $data['name'];
        $element_type->description = $data['description'];
        $element_type->requires_tree_type = $data['requires_tree_type'];
        $element_type->created_at = $data['created_at'];
        $element_type->updated_at = $data['updated_at'];
        $element_type->deleted_at = $data['deleted_at'];

        return $element_type;
    }

    public function elements(): array
    {
        return $this->hasMany(Element::class, 'element_type_id');
    }

}
