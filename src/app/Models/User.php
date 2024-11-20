<?php

namespace App\Models;

class User extends BaseModel
{
    public string $company;

    public string $name;

    public string $surname;

    public string $dni;

    public string $password;

    public string $email;

    public int $role_id;

    public ?int $photo_id;

    protected static function getTableName(): string
    {
        return 'users';
    }

    protected static function mapDataToModel($data): User
    {
        $user = new self();
        $user->id = $data['id'];
        $user->company = $data['company'];
        $user->name = $data['name'];
        $user->surname = $data['surname'];
        $user->dni = $data['dni'];
        $user->password = $data['password'];
        $user->email = $data['email'];
        $user->role_id = $data['role_id'];
        $user->photo_id = $data['photo_id'];
        $user->created_at = $data['created_at'];

        return $user;
    }

    public function role(): Role
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function photo(): ?Photo
    {
        if ($this->photo_id)
            return $this->belongsTo(Photo::class, 'photo_id');
    }
}
