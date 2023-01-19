<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function courses_R()
    {
        return $this->belongsToMany(Course::class, 'teacher_course');
    }

    public function department_R()
    {
        return $this->belongsTo(Department::class, 'department');
    }
}
