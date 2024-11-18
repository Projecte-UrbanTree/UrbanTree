<?php

namespace App\Models;

use App\Core\Database;

abstract class BaseModel
{
    protected ?int $id = null;

    protected $created_at;

    public function belongsTo(string $relatedModel, string $foreignKey, string $ownerKey = 'id'): ?object
    {
        $relatedTable = $relatedModel::getTableName();
        $foreignKeyValue = $this->{$foreignKey};

        if (is_null($foreignKeyValue)) {
            return null;
        }

        $query = "SELECT * FROM {$relatedTable} WHERE {$ownerKey} = :foreignKeyValue LIMIT 1";
        $results = Database::prepareAndExecute($query, ['foreignKeyValue' => $foreignKeyValue]);

        return ! empty($results) ? $relatedModel::mapDataToModel($results[0]) : null;
    }

    public function belongsToMany(
        string $relatedModel,
        string $pivotTable,
        string $foreignKey,
        string $relatedKey,
        string $ownerKey = 'id',
        string $relatedOwnerKey = 'id'
    ): array {
        $relatedTable = $relatedModel::getTableName();
        $localKeyValue = $this->{$ownerKey};

        $query = "
        SELECT {$relatedTable}.*
        FROM {$relatedTable}
        INNER JOIN {$pivotTable} ON {$pivotTable}.{$relatedKey} = {$relatedTable}.{$relatedOwnerKey}
        WHERE {$pivotTable}.{$foreignKey} = :localKeyValue
    ";

        $results = Database::prepareAndExecute($query, ['localKeyValue' => $localKeyValue]);

        // Ensure results are a valid array
        if (! is_array($results)) {
            $results = [];
        }

        return array_map(fn ($row) => $relatedModel::mapDataToModel($row), $results);
    }

    public function hasMany(string $relatedModel, string $foreignKey, string $localKey = 'id'): array
    {
        $relatedTable = $relatedModel::getTableName();
        $localKeyValue = $this->{$localKey};

        $query = "SELECT * FROM {$relatedTable} WHERE {$foreignKey} = :localKeyValue";
        $results = Database::prepareAndExecute($query, ['localKeyValue' => $localKeyValue]);

        // Ensure $results is an array
        if (! is_array($results)) {
            $results = [];
        }

        return array_map(fn ($row) => $relatedModel::mapDataToModel($row), $results);
    }

    public function delete()
    {
        $table = static::getTableName();

        if (static::hasSoftDelete()) {
            $query = "UPDATE {$table} SET deleted_at = NOW() WHERE id = :id";
            Database::prepareAndExecute($query, ['id' => $this->id]);
        } else {
            $query = "DELETE FROM {$table} WHERE id = :id";
            Database::prepareAndExecute($query, ['id' => $this->id]);
        }
    }

    public static function find($id)
    {
        $table = static::getTableName();

        // Check if the table supports soft deletes
        $query = "SELECT * FROM {$table} WHERE id = :id";
        if (static::hasSoftDelete()) {
            $query .= ' AND deleted_at IS NULL'; // Only fetch records that are not soft deleted
        }

        $query .= ' LIMIT 1';
        $results = Database::prepareAndExecute($query, ['id' => $id]);

        if (! empty($results)) {
            return static::mapDataToModel($results[0]);
        }

        return null;
    }

    public static function findBy($conditions, $single = false)
    {
        $table = static::getTableName();

        // Build the WHERE clause dynamically
        $whereClauses = [];
        $parameters = [];
        foreach ($conditions as $column => $value) {
            $whereClauses[] = "{$column} = :{$column}";
            $parameters[$column] = $value;
        }
        $whereClause = implode(' AND ', $whereClauses);

        // Construct the SQL query
        $query = "SELECT * FROM {$table} WHERE {$whereClause}";

        if ($single) {
            $query .= ' LIMIT 1';
        }

        $results = Database::prepareAndExecute($query, $parameters);

        if ($single) {
            return ! empty($results) ? static::mapDataToModel($results[0]) : null;
        }

        if (empty($results)) {
            return [];
        }

        return array_map(fn ($row) => static::mapDataToModel($row), $results);
    }

    public static function findAll($conditions = [])
    {
        $table = static::getTableName();
        $query = "SELECT * FROM {$table}";
        $params = [];

        // Add conditions for WHERE clause
        if (! empty($conditions)) {
            $clauses = [];
            foreach ($conditions as $key => $value) {
                $clauses[] = "{$key} = :{$key}";
                $params[$key] = $value;
            }
            $query .= ' WHERE '.implode(' AND ', $clauses);
        }

        // Check if the table supports soft deletes and exclude soft-deleted records
        if (static::hasSoftDelete()) {
            $query .= empty($conditions) ? ' WHERE' : ' AND';
            $query .= ' deleted_at IS NULL'; // Exclude soft-deleted records by default
        }

        $results = Database::prepareAndExecute($query, $params);

        return array_map(fn ($row) => static::mapDataToModel($row), $results);
    }

    // Fetch all soft deleted records
    public static function findSoftDeleted()
    {
        if (! static::hasSoftDelete()) {
            return [];
        }

        $table = static::getTableName();
        $query = "SELECT * FROM {$table} WHERE deleted_at IS NOT NULL";
        $results = Database::prepareAndExecute($query);

        return array_map(fn ($row) => static::mapDataToModel($row), $results);
    }

    public function restore()
    {
        if (static::hasSoftDelete()) {
            $table = static::getTableName();
            $query = "UPDATE {$table} SET deleted_at = NULL WHERE id = :id";
            Database::prepareAndExecute($query, ['id' => $this->id]);
        }
    }

    public function save()
    {
        $table = static::getTableName();
        $properties = get_object_vars($this);
        unset($properties['id']); // Avoid saving the id in the data fields

        if ($this->getId()) {
            // Update logic
            $fields = [];
            foreach ($properties as $key => $value) {
                $fields[] = "{$key} = :{$key}";
            }
            $query = "UPDATE {$table} SET ".implode(', ', $fields).' WHERE id = :id';
            $properties['id'] = $this->id;
        } else {
            // Insert logic
            $fields = array_keys($properties);
            $placeholders = array_map(fn ($field) => ":{$field}", $fields);
            $query = "INSERT INTO {$table} (".implode(', ', $fields).') VALUES ('.implode(', ', $placeholders).')';
        }

        Database::prepareAndExecute($query, $properties);

        if (! $this->id) {
            $this->id = Database::connect()->lastInsertId();
        }
    }

    // * Getters and Setters
    public function getId()
    {
        return $this->id;
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    // Dynamically check if a table has the deleted_at column
    protected static function hasSoftDelete()
    {
        static $softDeleteCache = [];
        $table = static::getTableName();

        if (! isset($softDeleteCache[$table])) {
            $query = "SHOW COLUMNS FROM {$table} LIKE 'deleted_at'";
            $result = Database::prepareAndExecute($query);
            $softDeleteCache[$table] = ! empty($result); // Cache the result
        }

        return $softDeleteCache[$table];
    }

    // * Abstract methods to enforce subclass implementation
    abstract protected static function getTableName();

    abstract protected static function mapDataToModel($data);
}
