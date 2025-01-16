<?php

namespace App\Models;

class Photo extends BaseModel
{
    public string $name;

    public string $path;

    protected static function getTableName(): string
    {
        return 'photos';
    }

    protected static function mapDataToModel($data): Photo
    {
        $photo = new self;
        $photo->id = $data['id'];
        $photo->name = $data['name'];
        $photo->path = $data['path'];
        $photo->created_at = $data['created_at'];
        $photo->updated_at = $data['updated_at'];
        $photo->deleted_at = $data['deleted_at'];

        return $photo;
    }

    public function incidences()
    {
        return $this->hasMany(Incidence::class, 'photo_id');
    }

    public function machines()
    {
        return $this->hasMany(Machine::class, 'photo_id');
    }

    public function pruningTypes()
    {
        return $this->hasMany(PruningType::class, 'photo_id');
    }

    public function taskTypes()
    {
        return $this->hasMany(TaskType::class, 'photo_id');
    }

    public function treeTypes()
    {
        return $this->hasMany(TreeType::class, 'photo_id');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'photo_id');
    }

    public function workReports()
    {
        return $this->belongsToMany(WorkReport::class, 'work_report_photos', 'photo_id', 'work_report_id');
    }
}
