<?php

namespace App\Models;

use App\Core\Database;

class TaskType{
    private $id;
    private $name;

    public function __construct($data = [])
    {
        foreach ($data as $key => $value){
            $this->$key = $value;
        }
    }
// Obtenir tots los tipus de tasca
    public static function getAll()
    {
        $query = "SELECT * FROM task_types";
        $results = Database::prepareAndExecute($query);
        foreach ($results as $key => $value) {
            $results[$key] = new self($value);
        }
        return $results;
    }
    public static function findById($id)
    {
        $query = "SELECT * FROM task_types WHERE id = :id";
        $results = Database::prepareAndExecute($query, ['id' => $id]);
        return $results ? new self($results[0]) : null;
    }
    public function create()
    {
        $query = "INSERT INTO task_types (name) VALUES (:name)";
        $params = ['name' => $this->name];
        return Database::prepareAndExecute($query, $params);
    }
    public function update()
    {
        $query = "UPDATE task_types SET name = :name WHERE id = :id";
        $params = [
            'id' => $this->id,
            'name' => $this->name
        ];
        return Database::prepareAndExecute($query, $params);
    }
    public static function delete($id)
    {
        $query = "DELETE FROM task_types WHERE id = :id";
        return Database::prepareAndExecute($query, ['id' => $id]);
    }
    // Getters i setters
    public function getId()
    {
        return $this->id;
    }
    public function getName()
    {
        return $this->name;
    }
    public function setName($name)
    {
        $this->name = $name;
    }
}


?>