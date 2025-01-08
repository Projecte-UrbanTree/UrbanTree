<?php

namespace App\Controllers\Admin;

use App\Core\Session;
use App\Core\View;
use App\Models\Contract;

class ContractController
{
    public function index($queryParams)
    {
        $contracts = Contract::findAll();
        
        View::render([
            'view' => 'Admin/Contract/Contracts',
            'title' => 'Contracts',
            'layout' => 'Admin/AdminLayout',
            'data' => ['contracts' => $contracts],
        ]);
    }

    public function create($queryParams)
    {
        View::render([
            'view' => 'Admin/Contract/Create',
            'title' => 'Nuevo Contrato',
            'layout' => 'Admin/AdminLayout',
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
        exit;
    }

    public function edit($id, $queryParams)
    {
        $contract = Contract::find($id);

        if (!$contract) {
            Session::set('error', 'Contrato no encontrado');
            header('Location: /admin/contracts');
            exit;
        }

        View::render([
            'view' => 'Admin/Contract/Edit',
            'title' => 'Editando Contrato',
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

            Session::set('success', 'Contrato actualizado correctamente');
        } else
            Session::set('error', 'Contrato no encontrado');

        header('Location: /admin/contracts');
        exit;
    }

    public function destroy($id, $queryParams)
    {
        $contract = Contract::find($id);

        if ($contract) {
            $contract->delete();
            Session::set('success', 'Contrato eliminado correctamente');
        } else
            Session::set('error', 'Contrato no encontrado');

        header('Location: /admin/contracts');
        exit;
    }
}
