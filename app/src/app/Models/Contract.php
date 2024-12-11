<?php

namespace App\Models;

class Contract extends BaseModel
{
    public string $name;

    public string $start_date;

    public ?string $end_date;

    public ?float $invoice_proposed;

    public ?float $invoice_agreed;

    public ?float $invoice_paid;

    protected static function getTableName(): string
    {
        return 'contracts';
    }

    protected static function mapDataToModel($data): Contract
    {
        $contract = new self();
        $contract->id = $data['id'];
        $contract->name = $data['name'];
        $contract->start_date = $data['start_date'];
        $contract->end_date = $data['end_date'];
        $contract->invoice_proposed = $data['invoice_proposed'];
        $contract->invoice_agreed = $data['invoice_agreed'];
        $contract->invoice_paid = $data['invoice_paid'];
        $contract->created_at = $data['created_at'];
        $contract->updated_at = $data['updated_at'];
        $contract->deleted_at = $data['deleted_at'];

        return $contract;
    }

    public function elements()
    {
        return $this->hasMany(Element::class, 'contract_id');
    }

    public function workOrders()
    {
        return $this->hasMany(WorkOrder::class, 'contract_id');
    }

    public function sensors()
    {
        return $this->hasMany(Sensor::class, 'contract_id');
    }
}
