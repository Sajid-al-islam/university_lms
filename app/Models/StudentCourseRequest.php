<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentCourseRequest extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function student()
    {
        return $this->belongsTo(User::class, 'user_id', 'id')->with('student');
    }

    public function section()
    {
        return $this->belongsTo(Section::class)->with('course');
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }

    public function teacher()
    {
        return $this->hasOne(User::class, 'id', 'teacher_id');
    }

    public function setReject($attribute = null)
    {
        return $this->fill(['isDeclined' => 1, 'declined_reason' => $attribute])->save();
    }
}
