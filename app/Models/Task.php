<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory;

    public $timestamps = false; 

    protected $fillable = ['subject_id', 'class_model_id', 'description', 'due_date', 'created_by', 'file_path', 'title', 'grade', 'comment', 'status','created_at','updated_at'];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function classModel()
    {
        return $this->belongsTo(ClassModel::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function submittedBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }

    public function period()
    {
        return $this->belongsTo(Period::class);
    }
}
