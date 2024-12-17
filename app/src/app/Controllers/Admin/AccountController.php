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
            'view' => 'Admin/AccountConfig/AccountConfig',
            'title' => 'Configuración de cuenta',
            'layout' => 'Admin/AdminLayout',
            'data' => [
                'user' => $user
            ]
        ]);
    }


    public function update($id, $postData)
    {

        $user = User::find(id: $id);

        if (!$user) {
            Session::set('error', 'Usuario no encontrado');
            header('Location: /admin/configuration');
            exit;
        }

        $user->name = $postData['name'];
        $user->surname = $postData['surname'];
        $user->save();

        // **warning: recharge the user session with the new data
        Session::set('user', [
            'id' => $user->getId(),
            'name' => $user->name,
            'surname' => $user->surname[0],
            'email' => $user->email,
            'role' => $user->role,

        ]);

        Session::set('success', 'Usuario actualizado correctamente');



        header('Location: /admin/configuration');
    }

    // method to update the password
    public function updatePassword($id, $postData)
    {

        $user = User::find(id: $id);


        if (!$user) {
            Session::set('error', 'Usuario no encontrado');
            header('Location: /admin/configuration');
            exit;
        }

        if (!password_verify($postData['current_password'], $user->password)) {
            Session::set('error', 'La contraseña actual es incorrecta');
            header('Location: /admin/configuration');
            exit;
        }


        if ($postData['password'] !== $postData['password_confirmation']) {
            Session::set('error', 'Las contraseñas no coinciden');
            header('Location: /admin/configuration');
            exit;
        }


        $user->password = password_hash($postData['password'], PASSWORD_DEFAULT);
        $user->save();

        session_unset();
        session_destroy(); 

        Session::set('success', 'Contraseña actualizada correctamente');
        header('Location: /admin/configuration');
    }
}
