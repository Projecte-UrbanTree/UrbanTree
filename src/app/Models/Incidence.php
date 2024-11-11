<?php

namespace App\Models;

use App\Core\Database;
use PDO;
use PDOException;


class Incidence
{
    private $id;
    private $name;
    private $photo;
    private $element_id;
    private $description;
    private $incident_date;

    public function __construct($data = [])
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
    }


    public static function getAll()
    {
        $query = "SELECT * FROM incidences";
        $results = Database::prepareAndExecute($query);
        foreach ($results as $key => $value) {
            $results[$key] = new self($value);
        }
        return $results;
    }

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

    public function getElementId()
    {
        return $this->element_id;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getPhoto()
    {
        return $this->photo;
    }

    public function setPhoto($photo)
    {
        $this->photo = $photo;
    }

    public function getIncidentDate()
    {
        return $this->incident_date;
    }

    public function setIncidentDate($incident_date)
    {
        $this->incident_date = $incident_date;
    }


}