<?php

namespace App\Models;

class MElement extends BaseModel
{
    public string $name;
    public int $zone_id;
    public int $point_id;
    public int $tree_type_id;

    protected static function getTableName(): string
    {
        return 'elements';
    }

    protected static function mapDataToModel($data): MElement
    {
        $element = new self();
        $element->id = $data['id'];
        $element->name = $data['name'];
        $element->zone_id = $data['zone_id'];
        $element->point_id = $data['point_id'];
        $element->tree_type_id = $data['tree_type_id'];
        $element->created_at = $data['created_at'];
        return $element;
    }

    public function zone(): MZone
    {
        return $this->belongsTo(MZone::class, 'zone_id');
    }

    public function point(): MPoint
    {
        return $this->belongsTo(MPoint::class, 'point_id');
    }

    public function treeType(): MTreeType
    {
        return $this->belongsTo(MTreeType::class, 'tree_type_id');
    }
}
