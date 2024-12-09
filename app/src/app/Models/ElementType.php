<?php

namespace App\Models;

class ElementType extends BaseModel
{
    public string $name;
    public ?string $description;

    protected static function getTableName(): string
    {
        return "element_types";  // Asegúrate de que el nombre de la tabla es correcto
    }

    protected static function mapDataToModel($data): elementType
    {
        // Asegurarse de que todos los campos sean asignados correctamente
        $elementType = new self();
        $elementType->id = $data['id'];
        $elementType->name = $data["name"];
        $elementType->description = $data["description"];

        return $elementType;
    }
}
