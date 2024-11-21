<?php

namespace App\Controllers;

use App\Core\View;
use App\Models\Contract;

class ContractController
{
    public function index()
    {
        $contracts = Contract::findAll();
        View::render([
            'view' => 'Contracts',
            'title' => 'Contracts',
            'layout' => 'MainLayout',
            'data' => ['contracts' => $contracts],
        ]);
    }

    public function create()
    {
        View::render([
            'view' => 'Contract/Create',
            'title' => 'Create Contract',
            'layout' => 'MainLayout',
            'data' => [],
        ]);
    }

    public function store($postData)
    {
        $contract = new Contract;
        $contract->name = $postData['name'];
        $contract->start_date = $postData['start_date'];
        $contract->end_date = $postData['end_date'];
        $contract->invoice_proposed = $postData['invoice_proposed'];
        $contract->invoice_agreed = $postData['invoice_agreed'];
        $contract->invoice_paid = $postData['invoice_paid'];

        // Guarda el contracte a la base de dades
        $contract->save();

        // Missatge de confirmació

        // Redirigeix a la llista de contractes
        header('Location: /contracts');
        exit;
    }

    public function edit($id)
    {
        $contract = Contract::find($id);
        View::render([
            'view' => 'Contract/Edit',
            'title' => 'Edit Contract',
            'layout' => 'MainLayout',
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

            // Guarda els canvis
            $contract->save();

        }

        // Redirigeix a la llista de contractes
        header('Location: /contracts');
        exit;
    }
}
