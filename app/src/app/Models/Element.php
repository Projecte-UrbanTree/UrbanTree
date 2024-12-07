<?php

namespace App\Models;

class Element extends BaseModel
{
    public string $name;

    public string $contract_id;

    public int $zone_id;

    // public int $point_id;

    public int $tree_type_id;

    protected static function getTableName(): string
    {
        return 'elements';
    }

    protected static function mapDataToModel($data): Element
    {
        $element = new self();
        $element->id = $data['id'];
        $element->name = $data['name'];
        $element->contract_id = $data['contract_id'];
        $element->zone_id = $data['zone_id'];
        // $element->point_id = $data['point_id'];
        $element->tree_type_id = $data['tree_type_id'];
        $element->created_at = $data['created_at'];

        return $element;
    }

    public function contract(): Contract
    {
        return $this->belongsTo(Contract::class, 'contract_id');
    }

    public function zone(): Zone
    {
        return $this->belongsTo(Zone::class, 'zone_id', 'id');
    }

    // public function point()
    // {
    //     return $this->belongsTo(Point::class, 'point_id', 'id');
    // }

    public function treeType(): TreeType
    {
        return $this->belongsTo(TreeType::class, 'tree_type_id', 'id');
    }
}
