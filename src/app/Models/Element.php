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

    // Static method to retrieve all workers
    public static function getAll()
    {
        $query = "SELECT * FROM workers";
        return Database::prepareAndExecute($query);
    }

    // Static method to find a worker by ID
    public static function findById($id)
    {
        $query = "SELECT * FROM workers WHERE id = :id AND deleted_at IS NULL";
        $results = Database::prepareAndExecute($query, ['id' => $id]);

        return $results ? new self($results[0]) : null;
    }

    // Static method to find a worker by DNI
    public static function findByDni($dni)
    {
        $query = "SELECT * FROM workers WHERE dni = :dni AND deleted_at IS NULL";
        $results = Database::prepareAndExecute($query, ['dni' => $dni]);

        return $results ? new self($results[0]) : null;
    }

    // Method to save a new worker
    public function save()
    {
        $query = "INSERT INTO workers (company, name, dni, password, email, role_id, created_at, updated_at) 
                  VALUES (:company, :name, :dni, :password, :email, :role_id, NOW(), NOW())";
        $params = [
            'company' => $this->company,
            'name' => $this->name,
            'dni' => $this->dni,
            'password' => password_hash($this->password, PASSWORD_BCRYPT), // Hashing password
            'email' => $this->email,
            'role_id' => $this->role_id
        ];

        return Database::prepareAndExecute($query, $params);
    }

    // Method to update an existing worker
    public function update()
    {
        $query = "UPDATE workers SET company = :company, name = :name, dni = :dni, email = :email, 
                  role_id = :role_id, updated_at = NOW() WHERE id = :id AND deleted_at IS NULL";
        $params = [
            'id' => $this->id,
            'company' => $this->company,
            'name' => $this->name,
            'dni' => $this->dni,
            'email' => $this->email,
            'role_id' => $this->role_id
        ];

        return Database::prepareAndExecute($query, $params);
    }

    // Method to delete a worker (soft delete by updating `deleted_at` timestamp)
    public function delete()
    {
        $query = "UPDATE workers SET deleted_at = NOW() WHERE id = :id";
        return Database::prepareAndExecute($query, ['id' => $this->id]);
    }

    // Getters and setters (you can add more as needed)
    public function getId()
    {
        return $this->id;
    }

    public function setCompany($company)
    {
        $this->company = $company;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function setDni($dni)
    {
        $this->dni = $dni;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setRoleId($role_id)
    {
        $this->role_id = $role_id;
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
