<?php

namespace App\Controllers\Admin;

use App\Core\Session;
use App\Core\View;
use App\Models\User;

class UserController
{
    public function index($queryParams)
    {
        $users = User::findAll();
        View::render([
            'view' => 'Admin/Users',
            'title' => 'Usuarios',
            'layout' => 'Admin/AdminLayout',
            'data' => ['users' => $users],
        ]);
    }

    public function create($queryParams)
    {
        View::render([
            'view' => 'Admin/User/Create',
            'title' => 'Nuevo Usuario',
            'layout' => 'Admin/AdminLayout',
        ]);
    }

    public function store($postData)
    {
        $user = new User();
        $user->company = $postData['company'];
        $user->name = $postData['name'];
        $user->surname = $postData['surname'];
        $user->dni = $postData['dni'];
        $user->email = $postData['email'];

        // Check if password is not empty before updating
        if (!empty($postData['password'])) {
            $user->password = password_hash($postData['password'], PASSWORD_DEFAULT);
        }

        $user->role = $postData['role'];
        $user->save();

        if ($user->getId())
            Session::set('success', 'Usuario creado correctamente');
        else
            Session::set('error', 'El usuario no se pudo crear');

        header('Location: /admin/users');
        exit;
    }

    public function edit($id, $queryParams)
    {
        $user = User::find($id);

        if (!$user) {
            Session::set('error', 'Usuario no encontrado');
            header('Location: /admin/users');
            exit;
        }

        View::render([
            'view' => 'Admin/User/Edit',
            'title' => 'Editando Usuario',
            'layout' => 'Admin/AdminLayout',
            'data' => ['user' => $user],
        ]);
    }

    public function update($id, $postData)
    {
        $user = User::find($id);
        if ($user) {
            $user->company = $postData['company'];
            $user->name = $postData['name'];
            $user->surname = $postData['surname'];
            $user->dni = $postData['dni'];
            $user->email = $postData['email'];
            $user->role = $postData['role'];
            $user->save();

            Session::set('success', 'Usuario actualizado correctamente');
        } else
            Session::set('error', 'Usuario no encontrado');

        header('Location: /admin/users');
        exit;
    }

    public function destroy($id, $queryParams)
    {
        $user = User::find($id);

        // verify the role
        $admin_count = User::count(['role' => 2]);
        if ($admin_count = 1) {
            Session::set('error', 'No se puede eliminar el único administrador');
        } else if ($user->role != 2) {
            $user->delete();
            Session::set('success', 'Usuario eliminado correctamente');
        } else
            Session::set('error', 'No se pueden eliminar administradores');

        header('Location: /admin/users');
        exit;
    }
}
