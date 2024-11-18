<?php

namespace App\Models;

class MWorker extends BaseModel
{

    public ?string $company;
    public ?string $name;
    public string $dni;
    public ?string $password;
    public ?string $email;
    public ?int $role_id;

    protected static function getTableName(): string
    {
        return 'workers';
    }

    protected static function mapDataToModel($data): MWorker
    {
        $user = new self();
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

    public function role(): MRole
    {
        return $this->belongsTo(MRole::class, 'role_id');
    }
}
