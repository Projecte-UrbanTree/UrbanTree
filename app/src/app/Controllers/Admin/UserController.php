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
            'title' => 'Manage Users',
            'layout' => 'Admin/AdminLayout',
            'data' => ['users' => $users],
        ]);

        Session::remove('success');
    }

    public function create($queryParams)
    {
        View::render([
            'view' => 'Admin/User/Create',
            'title' => 'Add User',
            'layout' => 'Admin/AdminLayout',
            'data' => [],
        ]);
    }

    public function store($postData)
    {
        $user = new User();
        $user->company = $postData['company'];
        $user->name = $postData['name'];
        $user->dni = $postData['dni'];
        $user->email = $postData['email'];

        // Check if password is not empty before updating
        if (!empty($postData['password'])) {
            $user->password = $postData['password'];
        }

        $user->role = $postData['role'];
        $user->save();

        Session::set('success', 'User created successfully');

        header('Location: /admin/users');
    }

    public function edit($id, $queryParams)
    {
        $user = User::find($id);
        View::render([
            'view' => 'Admin/User/Edit',
            'title' => 'Edit User',
            'layout' => 'Admin/AdminLayout',
            'data' => ['user' => $user],
        ]);
    }

    public function update($id, $postData)
    {
        $user = User::find($id);
        $user->company = $postData['company'];
        $user->name = $postData['name'];
        $user->dni = $postData['dni'];
        $user->email = $postData['email'];
        $user->role = $postData['role'];
        $user->save();

        Session::set('success', 'User updated successfully');

        header('Location: /admin/users');
    }

    public function destroy($id, $queryParams)
    {
        $user = User::find($id);
        $user->delete();

        Session::set('success', 'User deleted successfully');

        header('Location: /admin/users');
    }
}
