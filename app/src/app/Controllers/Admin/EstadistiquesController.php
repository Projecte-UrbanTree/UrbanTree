<?php

namespace App\Controllers\Admin;

use App\Core\View;
use App\Models\Estadistiques; 

class EstadistiquesController
{
    public function index($queryParams = [])
    {
        // Obtenim les dades del model correcte
        $grafiques = Estadistiques::findAll();
      

        // Comprova si $grafiques és null i assegura't que sigui un array
        $contracts = $contracts = Estadistiques::findAll();
        // Renderitzem la vista amb les dades
        View::render([
            'view' => 'Admin/Grafics',
            'title' => 'Grafiques',
            'layout' => 'Admin/AdminLayout',
            'contracts' => $contracts,
            'data' => ['grafics' => $grafiques],
        ]);
    }
}
namespace App\Models;

class BaseModel
{
    public static function findAll($filters = [], $includeDeleted = false)
    {
        // Simulació d'una consulta a la base de dades
        $result = static::queryDatabase($filters, $includeDeleted);

        // Evita que $result sigui null abans de passar-ho a array_map
        if (!is_array($result)) {
            $result = []; // Inicialitza com a array buit si cal
        }

        return array_map(function ($item) {
            return static::mapToModel($item);
        }, $result);
    }

    private static function queryDatabase($filters, $includeDeleted)
    {
        // Aquí aniria la lògica per consultar la base de dades
        return null; // Simulació d'un resultat null
    }

    private static function mapToModel($item)
    {
        // Lògica per mapejar una fila de la base de dades al model
        return $item;
    }
}