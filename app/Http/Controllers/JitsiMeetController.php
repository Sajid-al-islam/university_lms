<?php

namespace App\Http\Controllers;

use App\Models\ClassModule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JitsiMeetController extends Controller
{
    public function getRoom($id)
    {
        $roomId = ClassModule::where('id', $id)
            ->with('section')
            ->first();


        $students = $roomId->section->student_courses;
        $roomName = $roomId->section->course->name . '..' . $roomId->section->section_id;


        if ($roomId->section->teacher_id != Auth::id()) {
            foreach ($students as $student) {
                if ($student->student->id != Auth::id()) {
                    return abort(403);
                }
            }
        }

        return view('meet.jitsi', [
            'name' => Auth::user()->name,
            'email' => Auth::user()->email,
            'roomId' => $roomId->id,
            'roomName' => $roomName,
        ]);
    }
}
