<?php

Namespace App\Models;

use App\Core\Database;
use PDO;
use PDOException;

class TreeType
{
    private $id;
    private $species;
    private $subspecies;
    private $family;

    // Constructor para inicializar propiedades
    public function __construct($data = [])
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
    }

    // Método estático para recuperar todos los tipos de árboles
    public static function getAll()
    {
        $query = "SELECT * FROM tree_types";
        $results = Database::prepareAndExecute($query);
        foreach ($results as $key => $value) {
            $results[$key] = new self($value);
        }
        return $results;
    }

    // Método estático para encontrar un tipo de árbol por ID
    public static function findById($id)
    {
        $query = "SELECT * FROM tree_types WHERE id = :id";
        $results = Database::prepareAndExecute($query, ['id' => $id]);

        return $results ? new self($results[0]) : null;
    }

    // Método estático para encontrar un tipo de árbol por familia
    public static function findByFamily($family)
    {
        $query = "SELECT * FROM tree_types WHERE family = :family";
        $results = Database::prepareAndExecute($query, ['family' => $family]);

        return $results ? new self($results[0]) : null;
    }

    // Método para guardar un nuevo tipo de árbol
    public function save()
    {
        $query = "INSERT INTO tree_types (species, subspecies, family) 
                  VALUES (:species, :subspecies, :family)";
        $params = [
            'species' => $this->species,
            'subspecies' => $this->subspecies,
            'family' => $this->family,
        ];

        return Database::prepareAndExecute($query, $params);
    }

    // Getters y setters
    public function getId()
    {
        return $this->id;
    }

    public function getSpecies()
    {
        return $this->species;
    }

    public function getSubspecies()
    {
        return $this->subspecies;
    }

    public function getFamily()
    {
        return $this->family;
    }
}
