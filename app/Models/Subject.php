<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'subject_user', 'subject_id', 'user_id');
    }

    public function classes()
    {
        return $this->belongsToMany(ClassModel::class, 'class_subject');
    }

    public function classSubjects()
    {
        return $this->hasMany(ClassSubject::class, 'subject_id');
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    public function materials()
    {
        return $this->hasMany(Material::class);
    }
}
