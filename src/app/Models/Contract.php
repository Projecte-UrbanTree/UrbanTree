<?php

namespace App\Models;

class Contract extends BaseModel
{
    public $name;
    public $start_date;
    public $end_date;
    public $invoice_proposed;
    public $invoice_agreed;
    public $invoice_paid;

    protected static function getTableName()
    {
        return 'contracts';
    }

    protected static function mapDataToModel($data)
    {
        $contract = new Contract();
        $contract->id = $data['id'];
        $contract->name = $data['name'];
        $contract->start_date = $data['start_date'];
        $contract->end_date = $data['end_date'];
        $contract->invoice_proposed = $data['invoice_proposed'];
        $contract->invoice_agreed = $data['invoice_agreed'];
        $contract->invoice_paid = $data['invoice_paid'];
        $contract->created_at = $data['created_at'];

        return $contract;
    }
}
