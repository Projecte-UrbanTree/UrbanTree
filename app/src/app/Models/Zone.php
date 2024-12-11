<?php

namespace App\Models;

use App\Core\Database;

class Zone extends BaseModel
{
    public ?int $point_id;
    public ?ZonePredefined $predefined = null; // Declare predefined property
    public array $elements = []; // Declare elements property

    protected static function getTableName(): string
    {
        return 'zones';
    }

    protected static function mapDataToModel($data): Zone
    {
        $zone = new self();
        $zone->id = $data['id'];
        $zone->point_id = $data['point_id'];
        $zone->created_at = $data['created_at'];
        $zone->updated_at = $data['updated_at'];
        $zone->deleted_at = $data['deleted_at'];

        return $zone;
    }

    // Relationship to points
    public function point(): ?Point
    {
        return $this->point_id
            ? $this->belongsTo(Point::class, 'point_id')
            : null;
    }

    // Relationship to predefined zones
    public function predefined(): ?ZonePredefined
    {
        return $this->hasOne(ZonePredefined::class, 'zone_id', 'id');
    }

    // Relationship to elements
    public function elements(): array
    {
        return $this->hasMany(Element::class, 'zone_id', 'id');
    }

    // Fetch all predefined zones along with elements from all zones
    public static function getPredefinedZonesWithElements(): array
    {
        $query = "
            SELECT
                zones.*,
                zones_predefined.name AS predefined_name,
                zones_predefined.photo_id AS predefined_photo_id,
                elements.*
            FROM zones
            INNER JOIN zones_predefined ON zones.id = zones_predefined.zone_id
            LEFT JOIN elements ON zones.id = elements.zone_id
        ";

        $results = Database::prepareAndExecute($query);

        // Group results by zone and map to models
        $groupedZones = [];
        foreach ($results as $row) {
            // Map zone
            if (!isset($groupedZones[$row['id']])) {
                $zone = static::mapDataToModel($row);

                // Attach predefined zone details
                $zone->predefined = new ZonePredefined();
                $zone->predefined->id = $row['id'];
                $zone->predefined->zone_id = $row['zone_id'];
                $zone->predefined->name = $row['predefined_name'];
                $zone->predefined->photo_id = $row['predefined_photo_id'];
                $zone->predefined->created_at = $row['created_at'];
                $zone->predefined->updated_at = $row['updated_at'];
                $zone->predefined->deleted_at = $row['deleted_at'];

                $groupedZones[$row['id']] = $zone;
            }

            // Map elements
            if (!empty($row['name'])) { // Element name indicates a valid element
                $element = Element::mapDataToModel($row);
                $groupedZones[$row['id']]->elements[] = $element;
            }
        }

        return array_values($groupedZones);
    }
}
