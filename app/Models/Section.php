<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function teacher()
    {
        return $this->hasOne(User::class, 'id', 'teacher_id')->with('teacher');
    }

    public function student_courses()
    {
        return $this->hasMany(StudentCourses::class, 'section_id', 'id')->with('student');
    }


    public function attendance()
    {
        return $this->hasMany(Attendance::class, 'section_id', 'id');
    }
    // public function teacher_R()
    // {
    //     return $this->hasOne(Teacher::class, 'id', 'teacher_id')->with('user');
    // }
}
