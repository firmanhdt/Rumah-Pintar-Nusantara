<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClassModel extends Model
{
    use HasFactory;

    protected $table = 'class_models';
    protected $fillable = ['class'];

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'class_subject');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'class_user', 'class_model_id', 'user_id');
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
