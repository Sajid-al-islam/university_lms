<?php

namespace App\Traits;

trait GenerateStudentID
{
    public function generateID($user_id, $semester_id, $department_code)
    {
        return $department_code . $semester_id . $user_id;
    }
}
