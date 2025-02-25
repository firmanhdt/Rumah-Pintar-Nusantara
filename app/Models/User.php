<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable,CanResetPassword;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone_number',
        'birth_date',
        'role',
        'is_approved',
        'class_id',
        'period_id',
        'is_active',
        'is_edit',
        'deactivated_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    protected static function boot()
    {
        parent::boot();
    
        static::saving(function ($user) {
            if ($user->role === 'guru' && !empty($user->subjects)) {
                if ($user->exists) { // Pastikan user sudah ada sebelum sync
                    $classIds = ClassModel::pluck('id')->toArray();
                    $user->classes()->syncWithoutDetaching($classIds);
                }
            }
        });
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class);
    }

    public function classes()
    {
        return $this->belongsToMany(ClassModel::class, 'class_user', 'user_id', 'class_id');
    }

    public function classModel()
    {
        return $this->belongsTo(ClassModel::class, 'class_id');
    }

    public function tasks()
    {
        return $this->belongsToMany(Task::class, 'class_user', 'user_id', 'task_id');
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }

    public function materials()
    {
        return $this->hasMany(Material::class);
    }
    public function period()
    {
        return $this->belongsTo(Period::class);
    }

    public function finalGrades()
    {
        return $this->hasMany(FinalGrade::class);
    }
}
