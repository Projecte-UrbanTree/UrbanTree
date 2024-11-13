<?php

namespace App\Models;

use App\Core\Database;
use PDO;
use PDOException;

class PruningType
{
    private $id;
    private $name;
    private $description;

    // Constructor to initialize properties (optional)
    public function __construct($data = [])
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
    }

    // Static method to retrieve all pruning_type
    public static function getAll()
    {
        $query = "SELECT * FROM pruning_type";
        $results = Database::prepareAndExecute($query);
        foreach ($results as $key => $value) {
            $results[$key] = new self($value);
        }
        return $results;
    }

    // Static method to find a pruning type by ID
    public static function findById($id)
    {
        $query = "SELECT * FROM pruning_type WHERE id = :id AND deleted_at IS NULL";
        $results = Database::prepareAndExecute($query, ['id' => $id]);

        return $results ? new self($results[0]) : null;
    }

    // Static method to find a pruning type by Name
    public static function findByName($name)
    {
        $query = "SELECT * FROM pruning_type WHERE name = :name AND deleted_at IS NULL";
        $results = Database::prepareAndExecute($query, ['name' => $name]);

        return $results ? new self($results[0]) : null;
    }

    // Method to save a new pruning type
    public function save()
    {
        $query = "INSERT INTO pruning_type (name, description) 
                  VALUES (:name, :description)";
        $params = [
            'name' => $this->name,
            'description' => $this->description,
        ];

        return Database::prepareAndExecute($query, $params);
    }

    // Method to update an existing pruning type
    public function update()
    {
        $query = "UPDATE pruning_type SET name = :name, description = :description
                  WHERE id = :id AND deleted_at IS NULL";
        $params = [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
        ];

        return Database::prepareAndExecute($query, $params);
    }

    // Getters and setters (you can add more as needed)
    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

}
