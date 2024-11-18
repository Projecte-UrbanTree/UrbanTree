<?php

namespace App\Models;

class User extends BaseModel
{
    public string $company;

    public string $name;

    public string $dni;

    public string $password;

    public string $email;

    public int $role_id;

    // Fetch the user's role
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    protected static function getTableName()
    {
        return 'workers';
    }

    protected static function mapDataToModel($data)
    {
        $user = new User;
        $user->id = $data['id'];
        $user->company = $data['company'];
        $user->name = $data['name'];
        $user->dni = $data['dni'];
        $user->password = $data['password'];
        $user->email = $data['email'];
        $user->role_id = $data['role_id'];
        $user->created_at = $data['created_at'];

        return $user;
    }
}
