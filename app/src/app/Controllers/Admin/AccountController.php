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

        $user->name = isset($postData['name']) ? trim($postData['name']) : $user->name;
        $user->surname = isset($postData['surname']) ? trim($postData['surname']) : $user->surname;

        // save current data fields
        $currentPassword = isset($postData['current_password']) ? trim($postData['current_password']) : '';
        $newPassword = isset($postData['password']) ? trim($postData['password']) : '';
        $confirmPassword = isset($postData['password_confirmation']) ? trim($postData['password_confirmation']) : '';

        $isChangingPassword = !empty($currentPassword) || !empty($newPassword) || !empty($confirmPassword);

        if ($isChangingPassword) {
            if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
                Session::set('error', 'Por favor, completa todos los campos de contraseña para cambiarla.');
                header('Location: /admin/account');
                exit;
            }

            if ($newPassword !== $confirmPassword) {
                Session::set('error', 'Las nuevas contraseñas no coinciden.');
                header('Location: /admin/account');
                exit;
            }

            if (!password_verify($currentPassword, $user->password)) {
                Session::set('error', 'La contraseña actual es incorrecta.');
                header('Location: /admin/account');
                exit;
            }

            $user->password = password_hash($newPassword, PASSWORD_BCRYPT);
        } else {


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
