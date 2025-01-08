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

    public int $role;

    public ?int $photo_id;

    public function photo(): ?Photo
    {
        return $this->photo_id ? $this->belongsTo(Photo::class, 'photo_id') : null;
    }

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
        $user->role = $data['role'];
        $user->photo_id = $data['photo_id'];
        $user->created_at = $data['created_at'];
        $user->updated_at = $data['updated_at'];
        $user->deleted_at = $data['deleted_at'];

        return $user;
    }

    public static function getRoleName($role): string
    {
        return match ($role) {
            0 => 'Cliente',
            1 => 'Operario',
            2 => 'Admin'
        };
    }
}
