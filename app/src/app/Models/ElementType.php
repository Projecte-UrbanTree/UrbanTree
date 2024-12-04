<?php

namespace App\Models;

class ElementType extends BaseModel
{
    public string $name;
    public ?string $description;

    protected static function getTableName(): string
    {
        return "elementTypes";  // Asegúrate de que el nombre de la tabla es correcto
    }

    protected static function mapDataToModel(array $data): ElementType
    {
        // Asegurarse de que todos los campos sean asignados correctamente
        $element_type = new self();
        $element_type->id = $data['id'];
        $element_type->name = $data["name"];
        $element_type->description = $data["description"];
        $element_type->created_at = $data['created_at'];

        return $element_type;
    }
}
