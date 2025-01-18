<?php

namespace App\Models;

class WorkOrderBlockTask extends BaseModel
{
    public int $work_orders_block_id;

    public int $task_id;

    public int $element_type_id;

    public ?int $tree_type_id;

    public int $status;

    public ?string $spent_time;

    protected static function getTableName(): string
    {
        return 'work_orders_blocks_tasks';
    }

    protected static function mapDataToModel($data): WorkOrderBlockTask
    {
        $work_order_block_task = new self;
        $work_order_block_task->id = $data['id'];
        $work_order_block_task->work_orders_block_id = $data['work_orders_block_id'];
        $work_order_block_task->task_id = $data['task_id'];
        $work_order_block_task->element_type_id = $data['element_type_id'];
        $work_order_block_task->tree_type_id = $data['tree_type_id'];
        $work_order_block_task->status = $data['status'];
        $work_order_block_task->spent_time = $data['spent_time'] ?? null;

        return $work_order_block_task;
    }

    public function treeType(): ?TreeType
    {
        return $this->belongsTo(TreeType::class, 'tree_type_id');
    }

    public function task(): TaskType
    {
        return $this->belongsTo(TaskType::class, 'task_id');
    }

    public function block(): WorkOrderBlock
    {
        return $this->belongsTo(WorkOrderBlock::class, 'work_orders_block_id');
    }

    public function elementType(): ElementType
    {
        return $this->belongsTo(ElementType::class, 'element_type_id');
    }
}
