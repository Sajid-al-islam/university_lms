<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $student = $user->student;
        $teacher = $user->teacher;

        return $user->isTeacher ? view('profile.teacher', compact('teacher')) : view('profile.student', compact('student'));
    }

    public function show($id)
    {
        return view('profile.show');
    }
}
