<?php

namespace App\Controllers\Auth;

use App\Core\Session;
use App\Core\View;
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

        if (!$email || !$password) {
            // Redirect back with error if fields are missing
            Session::set('error', 'Email and password are required.');
            header('Location: /auth/login');
            exit;
        }

        // Check if the user exists and password matches
        $user = User::findBy(['email' => $email, 'password' => $password], true);

        if (!$user || strcmp($user->password, $password) !== 0) { // TODO: Verify hashed password not raw password
            echo 'Invalid email or password.';
            // Redirect back with error if authentication fails
            Session::set('error', 'Invalid email or password.');
            header('Location: /auth/login');
            exit;
        }

        Session::set('user', [
            'id' => $user->getId(),
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
        ]);

        if ($user->role === 1) {
            header('Location: /dashboard');
        } else {
            header('Location: /admin/dashboard');
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
