<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassSubject extends Model
{
    protected $table = 'class_subject'; 

    protected $fillable = ['subject_id', 'class_model_id'];

    // Relasi dengan Subject
    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    // Relasi dengan ClassModel
    public function classModel()
    {
        return $this->belongsTo(ClassModel::class, 'class_model_id');
    }
}
