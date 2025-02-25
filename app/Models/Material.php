<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    protected $table = 'materials';

    protected $fillable = [
        'name',
        'description',
        'thumbnail_path',
        'file_path',
        'subject_id',
        'class_model_id',
        'user_id',
    ];

    // Relasi dengan model Subject
    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    // Relasi dengan model Class
    public function class()
    {
        return $this->belongsTo(ClassModel::class, 'class_model_id');
    }

    // Relasi dengan model User (Guru)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
