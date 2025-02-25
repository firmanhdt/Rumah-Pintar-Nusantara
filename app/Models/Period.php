<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Period extends Model
{
    use HasFactory;

    protected $fillable = ['start_date', 'end_date'];

    // Relasi dengan Task
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    // Relasi dengan FinalGrade
    public function finalGrades()
    {
        return $this->hasMany(FinalGrade::class);
    }

    // Relasi dengan User (Murid)
    public function users()
    {
        return $this->belongsToMany(User::class, 'final_grades', 'period_id', 'student_id');
    }
}
