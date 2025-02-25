<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinalGrade extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'subject_id',
        'class_model_id',
        'final_grade',
        'period_id',
    ];

    // Relasi dengan model User (Siswa)
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    // Relasi dengan model Subject
    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    // Relasi dengan model ClassModel
    public function classModel()
    {
        return $this->belongsTo(ClassModel::class, 'class_model_id');
    }

    // Relasi dengan model Period
    public function period()
    {
        return $this->belongsTo(Period::class);
    }
}
