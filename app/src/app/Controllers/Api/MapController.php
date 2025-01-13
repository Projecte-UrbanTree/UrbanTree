<?php

namespace App\Controllers\Api;

use App\Core\Session;

use App\Models\Element;
use App\Models\Zone;
use App\Models\Point;
use App\Models\ElementType;
use App\Models\TreeType;
use Exception;

class MapController
{
    public function index($queryParams)
    {
        header('Content-Type: application/json');

        $contractId = Session::get('current_contract');
        if ($contractId == -1) {
            $zones = Zone::findAll();
        } else {
            $zones = Zone::findAll(['contract_id' => $contractId]);
        }
        $data = ['zones' => []];

        foreach ($zones as $zone) {
            $zoneData = [
                'id' => $zone->getId(),
                'color' => $zone->color,
                'name' => $zone->name,
                'description' => $zone->description,
                'points' => array_map(function ($point) {
                    return [$point->latitude, $point->longitude];
                }, $zone->points()),
                'element_types' => [],
            ];

            $elementTypes = ElementType::findAll();
            foreach ($elementTypes as $elementType) {
                if ($contractId == -1) {
                    $elements = $elementType->elements(['zone_id' => $zone->getId()]);
                } else {
                    $elements = $elementType->elements(['zone_id' => $zone->getId(), 'contract_id' => $contractId]);
                }
                $zoneData['element_types'][] = [
                    'id' => $elementType->getId(),
                    'icon' => $elementType->icon,
                    'color' => $elementType->color,
                    'name' => $elementType->name,
                    'elements' => array_map(function ($element) {
                        return [
                            'id' => $element->getId(),
                            'latitude' => $element->point()->latitude,
                            'longitude' => $element->point()->longitude,
                        ];
                    }, $elements),
                ];
            }

            $data['zones'][] = $zoneData;
        }

        echo json_encode($data);
        exit;
    }

    public function createZone($postData)
    {
        header('Content-Type: application/json');

        try {
            $contractId = Session::get('current_contract');
            if ($contractId == -1) {
                throw new Exception("Cannot create zone if contract is -1.");
            }
            $zone = new Zone();
            $zone->contract_id = $contractId;
            $zone->name = $postData['name'];
            $zone->color = $postData['color'];
            $zone->description = $postData['description'];
            $zone->save();

            foreach ($postData['points'] as $pointData) {
                $point = new Point();
                $point->latitude = $pointData[0];
                $point->longitude = $pointData[1];
                $point->zone_id = $zone->getId();
                $point->save();
            }

            echo json_encode(['status' => 'success', 'zone' => $zone]);
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
        exit;
    }

    public function deleteZone($postData)
    {
        header('Content-Type: application/json');

        try {
            $zoneId = $postData['id'];
            $zone = Zone::find($zoneId);
            if ($zone) {
                $zone->delete();
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Zone not found']);
            }
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
        exit;
    }

    public function createElement($postData)
    {
        header('Content-Type: application/json');

        try {
            $contractId = Session::get('current_contract');
            if ($contractId == -1) {
                throw new \Exception("Cannot create element if contract is -1.");
            }
            $point = new Point();
            $point->latitude = $postData['latitude'];
            $point->longitude = $postData['longitude'];
            $point->save();

            $element = new Element();
            $element->contract_id = $contractId;
            $element->zone_id = $postData['zone_id'];
            $element->element_type_id = $postData['element_type_id'];
            $element->point_id = $point->getId();
            $element->description = $postData['description'];
            $element->save();

            $point->element_id = $element->getId();
            $point->save();

            echo json_encode(['status' => 'success', 'element_id' => $element->getId()]);
        } catch (\Exception $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
        exit;
    }

    public function deleteElement($postData)
    {
        header('Content-Type: application/json');

        try {
            $elementId = $postData['id'];
            $element = Element::find($elementId);
            if ($element) {
                $element->delete();
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Element not found']);
            }
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
        exit;
    }

    public function getElementTypes($queryParams)
    {
        header('Content-Type: application/json');

        $types = ElementType::findAll();
        $data = [];
        foreach ($types as $type) {
            $data[] = [
                'id' => $type->getId(),
                'name' => $type->name,
                'description' => $type->description,
                'icon' => $type->icon,
                'color' => $type->color,
                'requires_tree_type' => $type->requires_tree_type,
            ];
        }
        echo json_encode($data);
        exit;
    }

    public function updateZoneName($postData)
    {
        header('Content-Type: application/json');

        try {
            $zone = Zone::find($postData['id']);
            if ($zone) {
                $zone->name = $postData['name'];
                $zone->save();
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Zone not found']);
            }
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
        exit;
    }

    public function updateZoneColor($postData)
    {
        header('Content-Type: application/json');

        try {
            $zone = Zone::find($postData['id']);
            if ($zone) {
                $zone->color = $postData['color'];
                $zone->save();
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Zone not found']);
            }
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
        exit;
    }

    public function getTreeTypes($queryParams)
    {
        header('Content-Type: application/json');

        $treeTypes = TreeType::findAll();
        $data = [];
        foreach ($treeTypes as $treeType) {
            $data[] = [
                'id' => $treeType->getId(),
                'family' => $treeType->family,
                'genus' => $treeType->genus,
                'species' => $treeType->species,
            ];
        }
        echo json_encode($data);
        exit;
    }

    public function getElement($id, $queryParams)
    {
        header('Content-Type: application/json');

        try {
            $elementId = $id;
            $element = Element::find($elementId);
            if ($element) {
                $data = [
                    'id' => $element->getId(),
                    'description' => $element->description,
                    'element_type' => $element->elementType(),
                    'zone' => $element->zone(),
                    'point' => $element->point(),
                    'tree_type' => $element->treeType(),
                ];
                echo json_encode($data);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Element not found']);
            }
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
        exit;
    }
}
