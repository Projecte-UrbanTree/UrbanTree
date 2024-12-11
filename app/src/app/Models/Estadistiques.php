<?php

namespace App\Models;

class Estadistiques extends BaseModel
{
    public string $litres;

    public string $hours;

    public string $pending;

    public string $filled;



    
    protected static function getTableName(): string
    {
        return 'Estadistiques';
    }

    protected static function mapDataToModel($data): Estadistiques
    {
        $estadistiques = new self();
        $estadistiques-> litres = $data['litres'];
        $estadistiques-> hours = $data['hours'];
        $estadistiques-> pending = $data["pending"];
        $estadistiques-> filled = $data["filled"];

     

        return $estadistiques;
    }

 
}