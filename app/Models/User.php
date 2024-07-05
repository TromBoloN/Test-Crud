<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role', 'nis',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    public function assignments()
    {
        return $this->hasMany(Assignment::class, 'teacher_id');
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class, 'student_id');
    }
}
