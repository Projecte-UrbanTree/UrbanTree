<?php

namespace App\Models;

class Element extends BaseModel
{
    public int $element_type_id;

    public int $contract_id;

    public int $zone_id;

    public ?int $point_id;

    public ?int $tree_type_id;

    public ?string $description;

    protected static function getTableName(): string
    {
        return 'elements';
    }

    protected static function mapDataToModel($data): Element
    {
        $element = new self;
        $element->id = $data['id'];
        $element->element_type_id = $data['element_type_id'];
        $element->contract_id = $data['contract_id'];
        $element->zone_id = $data['zone_id'];
        $element->point_id = $data['point_id'];
        $element->tree_type_id = $data['tree_type_id'];
        $element->description = $data['description'];
        $element->created_at = $data['created_at'];
        $element->updated_at = $data['updated_at'];
        $element->deleted_at = $data['deleted_at'];

        return $element;
    }

    public function elementType(): ElementType
    {
        return $this->belongsTo(ElementType::class, 'element_type_id');
    }

    public function contract(): Contract
    {
        return $this->belongsTo(Contract::class, 'contract_id');
    }

    public function zone(): Zone
    {
        return $this->belongsTo(Zone::class, 'zone_id');
    }

    public function point(): ?Point
    {
        return $this->belongsTo(Point::class, 'point_id');
    }

    public function treeType(): ?TreeType
    {
        return $this->tree_type_id ? $this->belongsTo(TreeType::class, 'tree_type_id') : null;
    }
}
