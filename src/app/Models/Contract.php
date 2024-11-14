<?php

namespace App\Models;

use App\Core\Database;
use PDO;
use PDOException;

class Contract
{
    private $id;
    private $company;
    private $name;
    private $dni;
    private $password;
    private $email;
    private $role_id;
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
        $query = "SELECT * FROM contracts";
        $results = Database::prepareAndExecute($query);
        foreach ($results as $key => $value) {
            $results[$key] = new self($value);
        }
        return $results;
    }

    // Static method to find a worker by ID
    public static function findById($id)
    {
        $query = "SELECT * FROM contracts WHERE id = :id AND deleted_at IS NULL";
        $results = Database::prepareAndExecute($query, ['id' => $id]);

        return $results ? new self($results[0]) : null;
    }

    // Static method to find a worker by DNI
    public static function findByDni($dni)
    {
        $query = "SELECT * FROM contracts WHERE id = :id AND deleted_at IS NULL";
        $results = Database::prepareAndExecute($query, ['id' => $dni]);

        return $results ? new self($results[0]) : null;
    }

    // Method to save a new worker
    public function save()
    {
        $query = "INSERT INTO contracts (company_type, start_date. end_date, salary, worker_id),
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
        $query = "UPDATE contracts SET contract_type = :company, name = :name, dni = :dni, email = :email, 
                  role_id = :role_id, updated_at = NOW() WHERE id = :id AND deleted_at IS NULL";
        $params = [
            'id' => $this->id,
            'contract_type' => $this->company,
            'start_date' => $this->name,
            'end_date' => $this->dni,
            'salary' => $this->email,
            'worker_id' => $this->role_id
        ];

        return Database::prepareAndExecute($query, $params);
    }

    // Method to delete a worker (soft delete by updating `deleted_at` timestamp)
    public function delete()
    {
        $query = "UPDATE contracts SET deleted_at = NOW() WHERE id = :id";
        return Database::prepareAndExecute($query, ['id' => $this->id]);
    }

    // Getters and setters (you can add more as needed)
    public function getId()
    {
        return $this->id;
    }

    public function getCompany()
    {
        return $this->company;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getDni()
    {
        return $this->dni;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getRoleId()
    {
        return $this->role_id;
    }

    public function setId($id)
    {
        $this->id = $id;
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
