<?php

namespace App\Controllers\Admin;

use App\Core\Session;
use App\Core\View;
use App\Models\User;

class AccountController
{
    public function index($queryParams)
    {

        $user = User::find(Session::get('user')['id']);
        View::render([
            'view' => 'Admin/Account',
            'title' => 'Configuración de cuenta',
            'layout' => 'Admin/AdminLayout',
            'data' => [
                'user' => $user
            ]
        ]);
    }


    public function update($postData)
    {
        $user = User::find(Session::get('user')['id']);

        if (!$user) {
            Session::set('error', 'Usuario no encontrado');
            header('Location: /admin/account');
            exit;
        }

        $user->name = $postData['name'];
        $user->surname = $postData['surname'];

        if (strlen($postData['current_password']) > 0) {

            if (!password_verify($postData['current_password'], $user->password)) {
                Session::set('error', 'Contraseña incorrecta');
                header('Location: /admin/account');
                exit;
            }

            if (empty($postData['password']) || empty($postData['password_confirmation'])) {
                Session::set('error', 'Completa los campos de contraseña');
                header('Location: /admin/account');
                exit;
            }

            if ($postData['password'] !== $postData['password_confirmation']) {
                Session::set('error', 'Las contraseñas no coinciden');
                header('Location: /admin/account');
                exit;
            }

            $user->password = password_hash($postData['password'], PASSWORD_BCRYPT);
        }

        $user->save();

        Session::set('user', [
            'id' => $user->getId(),
            'name' => $user->name,
            'surname' => $user->surname,
            'email' => $user->email,
            'role' => $user->role,
        ]);

        Session::set('success', 'Usuario y/o contraseña actualizados correctamente');
        header('Location: /admin/account');
    }
}
