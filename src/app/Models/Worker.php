<?php

namespace App\Models;

use App\Core\BaseModel;
use App\Core\Database;

class Worker extends BaseModel
{

    public string $company;
    public string $name;
    public string $dni;
    public string $password;
    public string $email;
    public int $role_id;

    protected static function getTableName()
    {
        return 'workers';
    }

    protected static function mapDataToModel($data)
    {
        $user = new Worker();
        $user->id = $data['id'];
        $user->company = $data['company'];
        $user->name = $data['name'];
        $user->dni = $data['dni'];
        $user->password = $data['password'];
        $user->email = $data['email'];
        $user->role_id = $data['role_id'];
        return $user;
    }

    // Fetch the user's role
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }
}
