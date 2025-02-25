<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'class_id',
        'subject_id',
        'start_time',
        'end_time',
        'teacher_id',
        'description',
    ];

    public function class()
    {
        return $this->belongsTo(ClassModel::class, 'class_id'); 
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id'); 
    }
}
