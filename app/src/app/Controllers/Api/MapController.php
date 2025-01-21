<?php

namespace App\Controllers\Api;

use App\Core\Session;
use App\Models\Element;
use App\Models\ElementType;
use App\Models\Incidence;
use App\Models\Point;
use App\Models\Sensor;
use App\Models\TreeType;
use App\Models\WorkOrderBlockTask;
use App\Models\Zone;
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
                'elementTypes' => [],
            ];

            $elementTypes = ElementType::findAll();
            foreach ($elementTypes as $elementType) {
                if ($contractId == -1) {
                    $elements = $elementType->elements(['zone_id' => $zone->getId()]);
                } else {
                    $elements = $elementType->elements(['zone_id' => $zone->getId(), 'contract_id' => $contractId]);
                }
                $zoneData['elementTypes'][] = [
                    'id' => $elementType->getId(),
                    'icon' => $elementType->icon,
                    'color' => $elementType->color,
                    'name' => $elementType->name,
                    'elements' => array_map(function ($element) {
                        return [
                            'id' => $element->getId(),
                            'latitude' => $element->point()->latitude,
                            'longitude' => $element->point()->longitude,
                            'hasIncidences' => Incidence::count(['element_id' => $element->getId()]) > 0,
                        ];
                    }, $elements),
                ];
            }
            $sensors = Sensor::findAll(['zone_id' => $zone->getId()]);
            $zoneData['elementTypes'][] = [
                'id' => -1,
                'icon' => 'fas fa-thermometer-half',
                'color' => '#FF5733',
                'name' => 'Sensor',
                'elements' => array_map(function ($sensor) {
                    return [
                        'id' => $sensor->getId(),
                        'latitude' => $sensor->point()->latitude,
                        'longitude' => $sensor->point()->longitude,
                        'is_active' => $sensor->is_active,
                    ];
                }, $sensors),
            ];

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
                throw new Exception('Cannot create zone if contract is -1.');
            }
            $zone = new Zone;
            $zone->contract_id = $contractId;
            $zone->name = $postData['name'];
            $zone->color = $postData['color'];
            $zone->description = $postData['description'];
            $zone->save();

            foreach ($postData['points'] as $pointData) {
                $point = new Point;
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
                throw new \Exception('Cannot create element if contract is -1.');
            }
            $point = new Point;
            $point->latitude = $postData['latitude'];
            $point->longitude = $postData['longitude'];
            $point->save();

            $element = new Element;
            $element->contract_id = $contractId;
            $element->zone_id = $postData['zoneId'];
            $element->element_type_id = $postData['elementTypeId'];
            $element->point_id = $point->getId();
            $element->description = $postData['description'];
            $element->tree_type_id = $postData['treeTypeId'] ?? null;
            $element->save();

            $point->element_id = $element->getId();
            $point->save();

            $elementData = [
                'id' => $element->getId(),
                'latitude' => $element->point()->latitude,
                'longitude' => $element->point()->longitude,
                'zoneId' => $element->zone_id,
                'elementTypeId' => $element->element_type_id,
                'description' => $element->description,
                'treeTypeId' => $element->tree_type_id,
            ];

            echo json_encode(['status' => 'success', 'element' => $elementData]);
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
                'requiresTreeType' => $type->requires_tree_type,
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

    public function updateZoneDescription($postData)
    {
        header('Content-Type: application/json');

        try {
            $zone = Zone::find($postData['id']);
            if ($zone) {
                $zone->description = $postData['description'];
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
            $element = Element::find($id);
            if ($element) {
                $data = [
                    'id' => $element->getId(),
                    'description' => $element->description,
                    'elementType' => $element->elementType(),
                    'zone' => $element->zone(),
                    'point' => $element->point(),
                    'treeType' => $element->treeType(),
                    'openIncidences' => Incidence::count(['element_id' => $element->getId(), 'status' => 'open']),
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

    public function updateElementDescription($postData)
    {
        header('Content-Type: application/json');

        try {
            $element = Element::find($postData['id']);
            if ($element) {
                $element->description = $postData['description'];
                $element->save();
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Element not found']);
            }
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
        exit;
    }

    public function getIncidences($id, $queryParams)
    {
        header('Content-Type: application/json');

        try {
            $incidences = Incidence::findAll(['element_id' => $id]);
            $data = [];
            foreach ($incidences as $incidence) {
                $data[] = [
                    'id' => $incidence->getId(),
                    'name' => $incidence->name,
                    'description' => $incidence->description,
                    'status' => $incidence->status,
                    'created_at' => $incidence->getCreatedAt(),
                ];
            }
            echo json_encode($data);
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
        exit;
    }

    public function createIncidence($id, $postData)
    {
        header('Content-Type: application/json');

        try {
            $elementId = $id;
            $incidence = new Incidence;
            $incidence->element_id = $elementId;
            $incidence->name = $postData['name'];
            $incidence->description = $postData['description'];
            $incidence->status = 'open';
            $incidence->save();
            echo json_encode(['status' => 'success', 'incidence' => $incidence]);
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
        exit;
    }

    public function toggleIncidenceStatus($id, $postData)
    {
        $incidence = Incidence::find($id);
        if ($incidence) {
            $incidence->status = $incidence->status === 'open' ? 'closed' : 'open';
            $incidence->save();
            echo json_encode(['status' => 'success', 'incidence' => $incidence]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Incidencia no encontrada.']);
        }
        exit;
    }

    public function deleteIncidence($id, $postData)
    {
        $incidence = Incidence::find($id);
        if ($incidence) {
            $incidence->delete();
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Incidence not found']);
        }
    }

    public function getElementHistory($id, $queryParams)
    {
        header('Content-Type: application/json');

        try {
            $element = Element::find($id);
            if ($element) {
                $tasks = WorkOrderBlockTask::findAll(['element_type_id' => $element->element_type_id]);
                $data = [];
                foreach ($tasks as $task) {
                    $data[] = [
                        'task_id' => $task->getId(),
                        'task_name' => $task->task()->name,
                        'date' => $task->getCreatedAt(),
                        'status' => $task->status == 1 ? 'completed' : 'pending',
                        'work_order_id' => $task->workOrderBlock()->workOrder()->getId(),
                    ];
                }
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
