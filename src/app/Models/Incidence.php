<?php

namespace App\Models;

use App\Core\Database;
use PDO;
use PDOException;


class Incidence
{
    private $name;
    private $description;
    private $photo;
    private $incident_date;

    public function __construct($data = [])
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }
    }


    public static function getAllIncidences()
    {
        $query = "SELECT * FROM incidences";
        $results = Database::prepareAndExecute($query);
        foreach ($results as $key => $value) {
            $results[$key] = new self($value);
        }
        return $results;
    }
}