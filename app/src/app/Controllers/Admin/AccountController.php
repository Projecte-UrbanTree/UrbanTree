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

        // detect password changes
        if (!empty($postData['password'])) {
            $user->password = password_hash($postData['password'], PASSWORD_DEFAULT);
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
        header('Location: /admin/configuration');
    }
}
