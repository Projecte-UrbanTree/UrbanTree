<?php

namespace App\Controllers\Admin;

use App\Core\View;
use App\Models\Contract;

class ContractController
{
    public function index($queryParams)
    {
        $contracts = Contract::findAll();
        View::render([
            'view' => 'Admin/Contracts',
            'title' => 'Contracts',
            'layout' => 'Admin/AdminLayout',
            'data' => ['contracts' => $contracts],
        ]);
    }

    public function create($queryParams)
    {
        View::render([
            'view' => 'Admin/Contract/Create',
            'title' => 'Create Contract',
            'layout' => 'Admin/AdminLayout',
            'data' => [],
        ]);
    }

    public function store($postData)
    {
        $contract = new Contract();
        $contract->name = $postData['name'];
        $contract->start_date = $postData['start_date'];
        $contract->end_date = $postData['end_date'];
        $contract->invoice_proposed = $postData['invoice_proposed'];
        $contract->invoice_agreed = $postData['invoice_agreed'];
        $contract->invoice_paid = $postData['invoice_paid'];

        $contract->save();

        header('Location: /admin/contracts');
    }

    public function edit($id, $queryParams)
    {
        $contract = Contract::find($id);
        View::render([
            'view' => 'Admin/Contract/Edit',
            'title' => 'Edit Contract',
            'layout' => 'Admin/AdminLayout',
            'data' => ['contract' => $contract],
        ]);
    }

    public function update($id, $postData)
    {
        $contract = Contract::find($id);

        if ($contract) {
            $contract->name = $postData['name'];
            $contract->start_date = $postData['start_date'];
            $contract->end_date = $postData['end_date'];
            $contract->invoice_proposed = $postData['invoice_proposed'];
            $contract->invoice_agreed = $postData['invoice_agreed'];
            $contract->invoice_paid = $postData['invoice_paid'];

            $contract->save();
        }

        header('Location: /admin/contracts');
    }

    public function destroy($id, $queryParams)
    {
        $contract = Contract::find($id);
        $contract->delete();

        header('Location: /admin/contracts');
    }
}
