<?php

namespace App\Models;

use App\Core\Database;

class WorkOrder extends BaseModel
{
    public int $contract_id;

    public string $date;

    protected static function getTableName(): string
    {
        return 'work_orders';
    }

    protected static function mapDataToModel($data): WorkOrder
    {
        $work_order = new self();
        $work_order->id = $data['id'];
        $work_order->contract_id = $data['contract_id'];
        $work_order->date = $data['date'];
        $work_order->created_at = $data['created_at'];
        $work_order->updated_at = $data['updated_at'];
        $work_order->deleted_at = $data['deleted_at'];

        return $work_order;
    }

    public function report(): WorkReport
    {
        return $this->hasOne(WorkReport::class, 'id');
    }

    public function contract(): Contract
    {
        return $this->belongsTo(Contract::class, 'contract_id');
    }

    public function users(): array
    {
        return $this->belongsToMany(User::class, 'work_orders_users', 'work_order_id', 'user_id');
    }

    public function blocks(): array
    {
        return $this->hasMany(WorkOrderBlock::class, 'work_order_id');
    }

    public static function paginateByDate(
        array $ids,          // Array of work order IDs to filter by
        string $referenceDate, // Reference date (YYYY-MM-DD)
        int $perPage = 3     // Always paginate 3 records (previous, current, next)
    ): ?array {
        if (empty($ids)) {
            return [];
        }

        // Query to fetch the records
        $query = "
            SELECT * FROM " . static::getTableName() . "
            WHERE id IN (" . implode(',', array_map('intval', $ids)) . ") 
              AND (
                (date < :referenceDate) OR
                (date = :referenceDate) OR
                (date > :referenceDate)
              )
            ORDER BY 
              CASE 
                WHEN date = :referenceDate THEN 1
                WHEN date < :referenceDate THEN 2
                WHEN date > :referenceDate THEN 3
              END, date ASC
            LIMIT :limit
        ";

        // Parameters for the query
        $params = [
            'referenceDate' => $referenceDate,
            'limit' => $perPage,
        ];

        // Execute query
        $results = Database::prepareAndExecute($query, $params);

        if (!is_array($results)) {
            return [];
        }

        // Map results to models
        return array_map(fn($row) => static::mapDataToModel($row), $results);
    }

}
