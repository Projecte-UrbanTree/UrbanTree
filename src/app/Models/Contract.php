<?php

namespace App\Models;

use App\Core\Database;
use PDO;
use PDOException;

class Contract
{
    private $id;
    private $contract_type;
    private $start_date;
    private $end_date;
    private $salary;
    private $worker_id;

    // Constructor per inicialitzar les propietats
    public function __construct($data = [])
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
    }

    // Mètode per obtenir tots els contractes
    public static function getAll()
    {
        $query = "SELECT * FROM contracts";
        $results = Database::prepareAndExecute($query);
        foreach ($results as $key => $value) {
            $results[$key] = new self($value);
        }
        return $results;
    }

    // Mètode per obtenir un contracte per ID
    public static function findById($id)
    {
        $query = "SELECT * FROM contracts WHERE id = :id";
        $results = Database::prepareAndExecute($query, ['id' => $id]);

        return $results ? new self($results[0]) : null;
    }

    // Mètode per guardar un nou contracte
    public function save()
    {
        $query = "INSERT INTO contracts (contract_type, start_date, end_date, salary, worker_id)
                  VALUES (:contract_type, :start_date, :end_date, :salary, :worker_id)";
        $params = [
            'contract_type' => $this->contract_type,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'salary' => $this->salary,
            'worker_id' => $this->worker_id,
        ];

        return Database::prepareAndExecute($query, $params);
    }

    // Mètode per actualitzar un contracte existent
    public function update()
    {
        $query = "UPDATE contracts SET contract_type = :contract_type, start_date = :start_date, 
                  end_date = :end_date, salary = :salary, worker_id = :worker_id WHERE id = :id";
        $params = [
            'contract_type' => $this->contract_type,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'salary' => $this->salary,
            'worker_id' => $this->worker_id,
            'id' => $this->id,
        ];

        return Database::prepareAndExecute($query, $params);
    }

    // Mètode per esborrar un contracte
    public function delete()
    {
        $query = "DELETE FROM contracts WHERE id = :id";
        return Database::prepareAndExecute($query, ['id' => $this->id]);
    }

    // Getters i setters
    public function getId()
    {
        return $this->id;
    }

    public function getContractType()
    {
        return $this->contract_type;
    }

    public function getStartDate()
    {
        return $this->start_date;
    }

    public function getEndDate()
    {
        return $this->end_date;
    }

    public function getSalary()
    {
        return $this->salary;
    }

    public function getWorkerId()
    {
        return $this->worker_id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setContractType($contract_type)
    {
        $this->contract_type = $contract_type;
    }

    public function setStartDate($start_date)
    {
        $this->start_date = $start_date;
    }

    public function setEndDate($end_date)
    {
        $this->end_date = $end_date;
    }

    public function setSalary($salary)
    {
        $this->salary = $salary;
    }

    public function setWorkerId($worker_id)
    {
        $this->worker_id = $worker_id;
    }
}
