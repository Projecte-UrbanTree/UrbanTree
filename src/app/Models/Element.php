<?php

namespace App\Models;

use App\Core\Database;
use PDO;
use PDOException;

class Element
{
    private $id;
    private $name;
    private $latitude;
    private $longitude;
    private $created_at;
    private $deleted_at;
    private $updated_at;

    // Constructor to initialize properties (optional)
    public function __construct($data = [])
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
    }

    // Static method to retrieve all elements
    public static function getAll()
    {
        $query = "SELECT * FROM elements";
        $results = Database::prepareAndExecute($query);
        foreach ($results as $key => $value) {
            $results[$key] = new self($value);
        }
        return $results;
    }

    // Static method to find a element by ID
    public static function findById($id)
    {
        $query = "SELECT * FROM elements WHERE id = :id AND deleted_at IS NULL";
        $results = Database::prepareAndExecute($query, ['id' => $id]);

        return $results ? new self($results[0]) : null;
    }

    // Static method to find a element by name
    public static function findByName($name)
    {
        $query = "SELECT * FROM elements WHERE name = :name AND deleted_at IS NULL";
        $results = Database::prepareAndExecute($query, ['name' => $name]);

        return $results ? new self($results[0]) : null;
    }

    // Method to save a new element
    public function save()
    {
        $query = "INSERT INTO elements (name, latitude, longitude, created_at, updated_at) 
                  VALUES (:name, :latitude, :longitude, NOW(), NOW())";
        $params = [
            'name' => $this->name,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
        ];

        return Database::prepareAndExecute($query, $params);
    }

    // Method to update an existing element
    public function update()
    {
        $query = "UPDATE elements SET name = :name, latitude = :latitude, longitude = :longitude, 
                   updated_at = NOW() WHERE id = :id AND deleted_at IS NULL";
        $params = [
            'id' => $this->id,
            'name' => $this->name,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude
        ];

        return Database::prepareAndExecute($query, $params);
    }

    // Method to delete a element (soft delete by updating `deleted_at` timestamp)
    public function delete()
    {
        $query = "UPDATE elements SET deleted_at = NOW() WHERE id = :id";
        return Database::prepareAndExecute($query, ['id' => $this->id]);
    }

    // Getters and setters (you can add more as needed)
    public function getId()
    {
        return $this->id;
    }


    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
    }
    public function getLatitude()
    {
        return $this->latitude;
    }

    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
    }
    public function getLongitude()
    {
        return $this->longitude;
    }

    public function setUpdatedAt($updated_at)
    {
        $this->updated_at = $updated_at;
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    public function getDeletedAt()
    {
        return $this->deleted_at;
    }

    public function getUpdatedAt()
    {
        return $this->updated_at;
    }
}
