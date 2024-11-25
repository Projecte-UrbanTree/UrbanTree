<?php

namespace App\Models;

use App\Core\Database;

abstract class BaseModel
{
    protected ?int $id;

    protected ?string $created_at;

    // Insert multiple records into the table
    public static function bulkInsert(array $records): void
    {
        $table = static::getTableName();
        $fields = array_keys($records[0]);
        $placeholders = array_map(fn($field) => ":{$field}", $fields);

        $query = "INSERT INTO {$table} (" . implode(", ", $fields) . ") VALUES ";
        $query .= implode(", ", array_fill(0, count($records), "(" . implode(", ", $placeholders) . ")"));

        $params = [];
        foreach ($records as $index => $record)
            foreach ($record as $key => $value)
                $params["{$key}_{$index}"] = $value;

        Database::prepareAndExecute($query, $params);
    }

    // One-to-one relationship
    public function belongsTo(string $relatedModel, string $foreignKey, string $ownerKey = 'id'): ?object
    {
        $relatedTable = $relatedModel::getTableName();
        $foreignKeyValue = $this->{$foreignKey};

        if ($foreignKeyValue === null)
            return null;

        $query = "SELECT * FROM {$relatedTable} WHERE {$ownerKey} = :foreignKeyValue LIMIT 1";
        $results = Database::prepareAndExecute($query, ['foreignKeyValue' => $foreignKeyValue]);

        return ! empty($results) ? $relatedModel::mapDataToModel($results[0]) : null;
    }

    // Many-to-Many relationship
    public function belongsToMany(
        string $relatedModel,
        string $pivotTable,
        string $foreignKey,
        string $relatedKey,
        string $ownerKey = 'id',
        string $relatedOwnerKey = 'id',
        bool $withPivot = false, // Enables returning pivot data
        bool $applySoftDelete = false // Enables soft delete checks
    ): array {
        $relatedTable = $relatedModel::getTableName();
        $localKeyValue = $this->{$ownerKey};

        // Start query construction
        $selectColumns = $withPivot
            ? "{$relatedTable}.*, {$pivotTable}.*"
            : "{$relatedTable}.*";

        $query = "
            SELECT {$selectColumns}
            FROM {$relatedTable}
            INNER JOIN {$pivotTable} ON {$pivotTable}.{$relatedKey} = {$relatedTable}.{$relatedOwnerKey}
            WHERE {$pivotTable}.{$foreignKey} = :localKeyValue
        ";

        // Add soft delete condition if enabled
        if ($applySoftDelete && method_exists($relatedModel, 'hasSoftDelete') && $relatedModel::hasSoftDelete())
            $query .= " AND {$relatedTable}.deleted_at IS NULL";

        $results = Database::prepareAndExecute($query, ['localKeyValue' => $localKeyValue]);

        if (! is_array($results))
            $results = [];

        // Process results
        return array_map(function ($row) use ($relatedModel, $withPivot) {
            $relatedInstance = $relatedModel::mapDataToModel($row);

            if ($withPivot) {
                // Attach pivot data as a property
                $relatedInstance->pivot = array_filter($row, function ($key) use ($relatedModel) {
                    return ! property_exists($relatedModel, $key);
                }, ARRAY_FILTER_USE_KEY);
            }

            return $relatedInstance;
        }, $results);
    }

    // Count the number of records in the table
    public static function count(array $conditions = []): ?int
    {
        $query = "SELECT COUNT(*) as count FROM " . static::getTableName();
        $params = [];

        if (! empty($conditions)) {
            $query .= " WHERE ";
            $query .= implode(' AND ', array_map(function ($key) {
                return "$key = :$key";
            }, array_keys($conditions)));

            $params = $conditions;
        }

        $result = Database::prepareAndExecute($query, $params);
        return $result[0]['count'];
    }

    // Delete a record from the table
    public function delete(): void
    {
        $table = static::getTableName();

        if (static::hasSoftDelete())
            $query = "UPDATE {$table} SET deleted_at = NOW() WHERE id = :id";
        else
            $query = "DELETE FROM {$table} WHERE id = :id";

        Database::prepareAndExecute($query, ['id' => $this->id]);
    }

    // Check if a record exists in the table
    public static function exists(array $conditions = []): bool
    {
        $query = "SELECT COUNT(*) as count FROM " . static::getTableName();
        $params = [];

        if (!empty($conditions)) {
            $query .= " WHERE ";
            $query .= implode(' AND ', array_map(function ($key) {
                return "$key = :$key";
            }, array_keys($conditions)));

            $params = $conditions;
        }

        $result = Database::prepareAndExecute($query, $params);
        return $result[0]['count'] > 0;
    }

    // Find a record by its ID
    public static function find(string $id): ?object
    {
        $table = static::getTableName();

        $query = "SELECT * FROM {$table} WHERE id = :id";
        if (static::hasSoftDelete())
            $query .= ' AND deleted_at IS NULL';
        $query .= ' LIMIT 1';

        $results = Database::prepareAndExecute($query, ['id' => $id]);

        return ! empty($results) ? static::mapDataToModel($results[0]) : null;
    }

    // Fetch all records from the table
    public static function findAll(array $filters = [], bool $includeDeleted = false): array
    {
        $query = "SELECT * FROM " . static::getTableName();
        $params = [];

        if (!empty($filters)) {
            $conditions = [];
            foreach ($filters as $key => $value) {
                $conditions[] = "{$key} = :{$key}";
                $params[$key] = $value;
            }
            $query .= " WHERE " . implode(' AND ', $conditions);
        }

        if (method_exists(static::class, 'hasSoftDelete') && static::hasSoftDelete() && !$includeDeleted)
            $query .= (empty($filters) ? " WHERE" : " AND") . " deleted_at IS NULL";

        $results = Database::prepareAndExecute($query, $params);

        return array_map(fn($row) => static::mapDataToModel($row), $results);
    }

    // Find a record by a specific column
    public static function findBy(array $conditions, bool $single = false): ?array
    {
        $table = static::getTableName();

        $whereClauses = [];
        $parameters = [];
        foreach ($conditions as $column => $value) {
            $whereClauses[] = "{$column} = :{$column}";
            $parameters[$column] = $value;
        }
        $whereClause = implode(' AND ', $whereClauses);

        $query = "SELECT * FROM {$table} WHERE {$whereClause}";

        if (static::hasSoftDelete())
            $query .= " AND deleted_at IS NULL";

        if ($single)
            $query .= ' LIMIT 1';

        $results = Database::prepareAndExecute($query, $parameters);

        if ($single)
            return ! empty($results) ? static::mapDataToModel($results[0]) : null;

        if (empty($results))
            return [];

        return array_map(fn($row) => static::mapDataToModel($row), $results);
    }

    // Fetch all soft deleted records
    public static function findSoftDeleted(): array
    {
        if (! static::hasSoftDelete())
            return [];

        $table = static::getTableName();
        $query = "SELECT * FROM {$table} WHERE deleted_at IS NOT NULL";
        $results = Database::prepareAndExecute($query);

        return array_map(fn($row) => static::mapDataToModel($row), $results);
    }

    // One-to-One relationship
    public function hasOne(string $relatedModel, string $foreignKey, string $localKey = 'id'): ?object
    {
        $relatedTable = $relatedModel::getTableName();
        $localKeyValue = $this->{$localKey};

        $query = "SELECT * FROM $relatedTable WHERE $foreignKey = :localKeyValue LIMIT 1";
        $results = Database::prepareAndExecute($query, ['localKeyValue' => $localKeyValue]);

        return ! empty($results) ? $relatedModel::mapDataToModel($results[0]) : null;
    }

    // One-to-Many relationship
    public function hasMany(string $relatedModel, string $foreignKey, string $localKey = 'id'): array
    {
        $relatedTable = $relatedModel::getTableName();
        $localKeyValue = $this->{$localKey};

        $query = "SELECT * FROM {$relatedTable} WHERE {$foreignKey} = :localKeyValue";
        $results = Database::prepareAndExecute($query, ['localKeyValue' => $localKeyValue]);

        // Ensure $results is an array
        if (! is_array($results))
            $results = [];

        return array_map(fn($row) => $relatedModel::mapDataToModel($row), $results);
    }

    // Check if the table has a deleted_at column
    protected static function hasSoftDelete(): bool
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

    // Paginate the records in the table
    public static function paginate(int $page = 1, int $perPage = 10, array $conditions = []): ?array
    {
        $offset = ($page - 1) * $perPage;
        $query = "SELECT * FROM " . static::getTableName();
        $params = [];

        if (! empty($conditions)) {
            $query .= " WHERE " . implode(' AND ', array_map(fn($key) => "{$key} = :{$key}", array_keys($conditions)));
            $params = $conditions;
        }

        if (static::hasSoftDelete())
            $query .= (empty($conditions) ? " WHERE" : " AND") . " deleted_at IS NULL";

        $query .= " LIMIT :limit OFFSET :offset";
        $params['limit'] = $perPage;
        $params['offset'] = $offset;

        return Database::prepareAndExecute($query, $params);
    }

    // Restore a soft deleted record
    public function restore(): void
    {
        if (static::hasSoftDelete()) {
            $table = static::getTableName();
            $query = "UPDATE {$table} SET deleted_at = NULL WHERE id = :id";
            Database::prepareAndExecute($query, ['id' => $this->id]);
        }
    }

    // Create or update the record to the database
    public function save(): void
    {
        $table = static::getTableName();
        $properties = get_object_vars($this);
        unset($properties['id']); // Avoid saving the id in the data fields

        if (isset($this->id)) {
            // Update logic
            $fields = [];
            foreach ($properties as $key => $value)
                $fields[] = "{$key} = :{$key}";
            $fields[] = "updated_at = NOW()";
            $query = "UPDATE {$table} SET " . implode(", ", $fields) . " WHERE id = :id";
            $properties['id'] = $this->id;
        } else {
            // Insert logic
            $fields = array_keys($properties);
            $placeholders = array_map(fn($field) => ":{$field}", $fields);
            $query = "INSERT INTO {$table} (" . implode(", ", $fields) . ") VALUES (" . implode(", ", $placeholders) . ")";
        }

        Database::prepareAndExecute($query, $properties);

        if (! isset($this->id))
            $this->id = Database::connect()->lastInsertId();
    }

    //* Abstract methods to enforce subclass implementation
    abstract protected static function getTableName(): string;
    abstract protected static function mapDataToModel(array $data): object;

    //* Getters and Setters
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?string
    {
        return $this->created_at;
    }
}
