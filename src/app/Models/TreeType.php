<?php

Namespace App\Models;

use App\Core\Database;
use PDO;
use PDOException;

class TreeType
{
    private int $id;
    private string $family;
    private string $genus;
    private string $species;

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


    public static function findByGenus($genus)
    {
        $query = "SELECT * FROM tree_types WHERE genus = :genus";
        $results = Database::prepareAndExecute($query, ['genus' => $genus]);

        return $results ? new self($results[0]) : null;
    }


    public static function findBySpecies($species)
    {
        $query = "SELECT * FROM tree_types WHERE species = :species";
        $results = Database::prepareAndExecute($query, ['species' => $species]);
        return $results ? new self($results[0]) : null;
    }


    // Método para guardar un nuevo tipo de árbol
    public function save()
    {
        $query = "INSERT INTO tree_types (family, genus, species)
                  VALUES (:family, :genus, :species)";
        $params = [
            'family' => $this->family,
            'genus' => $this->genus,
            'species' => $this->species
        ];

        return Database::prepareAndExecute($query, $params);
    }

    public function update()
    {
        $query = "UPDATE tree_types SET family = :family, genus = :genus, species = :species
                  WHERE id = :id";
        $params = [
            'id' => $this->id,
            'family' => $this->family,
            'genus' => $this->genus,
            'species' => $this->species,
        ];

        return Database::prepareAndExecute($query, $params);
    }

    // Method to delete a tree type (hard delete)
    public function delete()
    {
        $query = "DELETE FROM tree_types WHERE id = :id";
        return Database::prepareAndExecute($query, ['id' => $this->id]);
    }


    // Getters y setters
    public function getId()
    {
        return $this->id;
    }

    public function getFamily()
    {
        return $this->family;
    }

    public function getGenus()
    {
        return $this->genus;
    }

    public function getSpecies()
    {
        return $this->species;
    }

    public function setFamily($family)
    {
        $this->family = $family;
    }

    public function setGenus($genus)
    {
        $this->genus = $genus;
    }

    public function setSpecies($species)
    {
        $this->species = $species;
    }
}
