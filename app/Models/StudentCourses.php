<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentCourses extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function student()
    {
        return $this->belongsTo(User::class, 'user_id', 'id')->with('student');
    }
    public function students()
    {
        return $this->hasMany(User::class, 'id', 'user_id');
    }

    public function section()
    {
        return $this->belongsTo(Section::class)->with(['course', 'teacher']);
    }

    public function single_section()
    {
        return $this->belongsTo(Section::class,'section_id');
    }

    public function single_course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }
    

    // public function course_result()
    // {
    //     return $this->belongsTo(Course::class);
    // }

    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }
}
