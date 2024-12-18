<?php
namespace App\Models;
class WorkOrderBlockTask extends BaseModel
{
    public int $work_orders_block_id;
    public int $task_id;
    public ?int $tree_type_id;
    public int $status;

    protected static function getTableName(): string
    {
        return 'work_orders_blocks_tasks';
    }

    protected static function mapDataToModel($data): WorkOrderBlockTask
    {
        $workOrderBlockTask = new self();
        $workOrderBlockTask->id = $data['id'];
        $workOrderBlockTask->work_orders_block_id = $data['work_orders_block_id'];
        $workOrderBlockTask->task_id = $data['task_id'];
        $workOrderBlockTask->tree_type_id = $data['tree_type_id'];
        $workOrderBlockTask->status = $data['status'];

        return $workOrderBlockTask;
    }

    public function treeType(): ?TreeType
    {
        return $this->belongsTo(TreeType::class, 'tree_type_id');
    }

    public function task(): TaskType
    {
        return $this->belongsTo(TaskType::class, 'task_id');
    }
}