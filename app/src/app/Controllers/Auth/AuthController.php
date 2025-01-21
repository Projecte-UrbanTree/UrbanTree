<?php

namespace App\Controllers\Auth;

use App\Core\Session;
use App\Core\View;
use App\Models\Contract;
use App\Models\User;

class AuthController
{
    public function index($queryParams)
    {
        View::render([
            'view' => 'Auth/Login',
            'title' => 'Login Page',
            'layout' => 'AuthLayout',
            'data' => [
                'error' => Session::get('error'),
            ],
        ]);

        // Clear the error message after displaying it
        Session::remove('error');
    }

    public function login($postData)
    {
        $email = $postData['email'] ?? null;
        $password = $postData['password'] ?? null;

        if (! $email || ! $password) {
            // Redirect back with error if fields are missing
            Session::set('error', 'Por favor, ingresa tu email y contraseña.');
            header('Location: /auth/login');
            exit;
        }

        // Check if the user exists and password matches
        $user = User::findBy(['email' => $email], true);

        if (! $user || ! password_verify($password, $user->password)) {
            // Redirect back with error if authentication fails
            Session::set('error', 'Has ingresado un email o contraseña incorrectos.');
            header('Location: /auth/login');
            exit;
        }

        if ($user->role == 1 || $user->role == 2) {
            $contracts = Contract::findAll();
            foreach ($contracts as $contract) {
                $currentDate = date('Y-m-d');
                if ($currentDate > $contract->start_date && $currentDate < $contract->end_date) {
                    $contract_id = $contract->getId();
                    break;
                }
            }
            if (! isset($contract_id)) {
                $contract_id = -1;
            }
        } else {
            $contract_id = null;
        }

        Session::set('user', [
            'id' => $user->getId(),
            'name' => $user->name,
            'surname' => $user->surname[0],
            'email' => $user->email,
            'role' => $user->role,
        ]);

        Session::set('current_contract', $contract_id);

        if ($user->role === 0) {
            header('Location: /customer');
        } elseif ($user->role === 1) {
            header('Location: /worker/work-orders');
        } elseif ($user->role === 2) {
            header('Location: /admin');
        }
        exit;
    }

    public function logout($queryParams)
    {
        Session::destroy();
        header('Location: /auth/login');
        exit;
    }
}
