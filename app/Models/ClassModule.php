<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassModule extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id', 'id')->with('course', 'teacher', 'student_courses');
    }

    public function student_courses()
    {
        return $this->hasManyThrough(StudentCourses::class, Section::class);
    }

    public function announcement()
    {
        return $this->hasMany(Announcement::class, 'class_id', 'id');
    }

    public function module()
    {
        return $this->hasMany(Module::class, 'class_id', 'id');
    }

    public function lesson()
    {
        return $this->hasMany(Lesson::class, 'class_id', 'id');
    }

    public function student_results() {
        return $this->hasMany(StudentCourses::class, 'class_id', 'id');
    }
}
