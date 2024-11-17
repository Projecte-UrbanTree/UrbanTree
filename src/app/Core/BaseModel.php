<?php

namespace App\Core;

abstract class BaseModel
{
    protected int $id;

    // One-to-one relationship
    public function belongsTo($relatedModel, $foreignKey, $ownerKey = 'id')
    {
        $relatedTable = $relatedModel::getTableName();
        $foreignKeyValue = $this->{$foreignKey};

        $query = "SELECT * FROM $relatedTable WHERE $ownerKey = :foreignKeyValue LIMIT 1";
        $results = Database::prepareAndExecute($query, ['foreignKeyValue' => $foreignKeyValue]);

        return !empty($results) ? $relatedModel::mapDataToModel($results[0]) : null;
    }


    // Many-to-Many relationship
    public function belongsToMany($relatedModel, $pivotTable, $foreignKey, $relatedKey, $ownerKey = 'id', $relatedOwnerKey = 'id')
    {
        $relatedTable = $relatedModel::getTableName();
        $localKeyValue = $this->{$ownerKey};

        $query = "
            SELECT $relatedTable.*
            FROM $relatedTable
            INNER JOIN $pivotTable ON $pivotTable.$relatedKey = $relatedTable.$relatedOwnerKey
            WHERE $pivotTable.$foreignKey = :localKeyValue
        ";

        $results = Database::prepareAndExecute($query, ['localKeyValue' => $localKeyValue]);

        return array_map(fn($row) => $relatedModel::mapDataToModel($row), $results);
    }

    public function delete()
    {
        $table = static::getTableName();

        if (static::hasSoftDelete()) {
            $query = "UPDATE $table SET deleted_at = NOW() WHERE id = :id";
            Database::prepareAndExecute($query, ['id' => $this->id]);
        } else {
            $query = "DELETE FROM $table WHERE id = :id";
            Database::prepareAndExecute($query, ['id' => $this->id]);
        }
    }

    public static function find($id)
    {
        $table = static::getTableName();
        $query = "SELECT * FROM $table WHERE id = :id LIMIT 1";
        $results = Database::prepareAndExecute($query, ['id' => $id]);

        if (!empty($results))
            return static::mapDataToModel($results[0]);

        return null;
    }

    public static function findAll($conditions = [])
    {
        $table = static::getTableName();
        $query = "SELECT * FROM $table";
        $params = [];

        if (!empty($conditions)) {
            $clauses = [];
            foreach ($conditions as $key => $value) {
                $clauses[] = "$key = :$key";
                $params[$key] = $value;
            }
            $query .= " WHERE " . implode(" AND ", $clauses);
        }

        $results = Database::prepareAndExecute($query, $params);

        return array_map(fn($row) => static::mapDataToModel($row), $results);
    }

    // Fetch all soft deleted records
    public static function findSoftDeleted()
    {
        if (!static::hasSoftDelete())
            return [];

        $table = static::getTableName();
        $query = "SELECT * FROM $table WHERE deleted_at IS NOT NULL";
        $results = Database::prepareAndExecute($query);

        return array_map(fn($row) => static::mapDataToModel($row), $results);
    }

    // Dynamically relationship fetching
    public function hasMany($relatedModel, $foreignKey, $localKey = 'id')
    {
        $relatedTable = $relatedModel::getTableName();
        $localKeyValue = $this->{$localKey};

        $query = "SELECT * FROM $relatedTable WHERE $foreignKey = :localKeyValue";
        $results = Database::prepareAndExecute($query, ['localKeyValue' => $localKeyValue]);

        return array_map(fn($row) => $relatedModel::mapDataToModel($row), $results);
    }

    // Dynamically check if a table has the deleted_at column
    protected static function hasSoftDelete()
    {
        static $softDeleteCache = [];
        $table = static::getTableName();

        if (!isset($softDeleteCache[$table])) {
            $query = "SHOW COLUMNS FROM $table LIKE 'deleted_at'";
            $result = Database::prepareAndExecute($query);
            $softDeleteCache[$table] = !empty($result); // Cache the result
        }

        return $softDeleteCache[$table];
    }

    public function restore()
    {
        if (static::hasSoftDelete()) {
            $table = static::getTableName();
            $query = "UPDATE $table SET deleted_at = NULL WHERE id = :id";
            Database::prepareAndExecute($query, ['id' => $this->id]);
        }
    }

    public function save()
    {
        $table = static::getTableName();
        $properties = get_object_vars($this);
        unset($properties['id']); // Avoid saving the id in the data fields

        if ($this->id) {
            // Update logic
            $fields = [];
            foreach ($properties as $key => $value) {
                $fields[] = "$key = :$key";
            }
            $query = "UPDATE $table SET " . implode(", ", $fields) . " WHERE id = :id";
            $properties['id'] = $this->id;
        } else {
            // Insert logic
            $fields = array_keys($properties);
            $placeholders = array_map(fn($field) => ":$field", $fields);
            $query = "INSERT INTO $table (" . implode(", ", $fields) . ") VALUES (" . implode(", ", $placeholders) . ")";
        }

        Database::prepareAndExecute($query, $properties);

        if (!$this->id)
            $this->id = Database::connect()->lastInsertId();
    }

    //* Abstract methods to enforce subclass implementation
    abstract protected static function getTableName();
    abstract protected static function mapDataToModel($data);

    //* Getters and Setters
    public function getId()
    {
        return $this->id;
    }
}
