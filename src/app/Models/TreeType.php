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


    // Constructor to initialize properties (optional)
    public function __construct($data = [])
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
    }

    // Static method to retrieve all tree_types
    public static function getAll()
    {
        $query = "SELECT * FROM tree_types";
        $results = Database::prepareAndExecute($query);
        foreach ($results as $key => $value) {
            $results[$key] = new self($value);
        }
        return $results;
    }

    // Static method to find a tree_type by ID
    public static function findById($id)
    {
        $query = "SELECT * FROM tree_types WHERE id = :id AND deleted_at IS NULL";
        $results = Database::prepareAndExecute($query, ['id' => $id]);

        return $results ? new self($results[0]) : null;
    }

    // Static method to find a tree_type by family
    public static function findByfamily($family)
    {
        $query = "SELECT * FROM tree_types WHERE family = :family AND deleted_at IS NULL";
        $results = Database::prepareAndExecute($query, ['family' => $family]);

        return $results ? new self($results[0]) : null;
    }

    // Method to save a new tree_type
    public function save()
    {
        $query = "INSERT INTO tree_types (species, subspecies, family) 
                  VALUES (:species, :subspecies, :family, NOW(), NOW())";
        $params = [
            'species' => $this->species,
            'subspecies' => $this->subspecies,
            'family' => $this->family,
        ];

        return Database::prepareAndExecute($query, $params);
    }
 

    // Getters and setters (you can add more as needed)
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
