<?php

namespace App\Models;

class Element extends BaseModel
{
    public int $element_type_id;

    public string $contract_id;

    public int $zone_id;

    public int $point_id;

    public int $tree_type_id;

    protected static function getTableName(): string
    {
        return 'elements';
    }

    protected static function mapDataToModel($data): Element
    {
        $element = new self();
        $element->id = $data['id'];
        $element->element_type_id = $data['element_type_id'];
        $element->contract_id = $data['contract_id'];
        $element->zone_id = $data['zone_id'];
        $element->point_id = $data['point_id'];
        $element->tree_type_id = $data['tree_type_id'];
        $element->created_at = $data['created_at'];
        return $element;
    }

    public function elementType()
    {
        return $this->hasMany(ElementType::class, 'element_type_id', 'id');
    }
    public function contract()
    {
        return $this->hasMany(Contract::class, 'contract_id','id');
    }
    public function zone()
    {
        return $this->hasMany(Zone::class, 'zone_id', 'id');
    }

    public function point()
    {
        return $this->hasMany(Point::class, 'point_id', 'id');
    }

    public function treeType()
    {
        return $this->hasMany(TreeType::class, 'tree_type_id', 'id');
    }
}
