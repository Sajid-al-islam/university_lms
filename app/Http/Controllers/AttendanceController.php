<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sections = Section::whereHas('student_courses', function ($query) {
            return $query->where('user_id', Auth::id());
        })->orWhereHas('teacher', function ($query2) {
            return $query2->where('id', Auth::id());
        })
            ->with('course')
            ->get();

        return view('attendance.index', compact('sections'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'section_id' => 'required',
        ]);

        foreach ($request->attendance as $attendance => $value) {
            Attendance::create([
                'section_id' => $request->section_id,
                'student_id' => $attendance,
                'attended' => $value
            ]);
        }

        return redirect('/dashboard/attendance')->with('succes', "Attendance Recorded Successfully");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $students = Section::where('id', $id)
            ->with('student_courses')
            ->get();

        $attendances = Attendance::where(['section_id' => $id, 'student_id' => Auth::id()])->get();

        if ($students[0]->teacher_id != Auth::id()) {
            return view('attendance.student', ['attendances' => $attendances]);
        }

        return view('attendance.show', ['students' => $students]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function edit(Attendance $attendance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Attendance $attendance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function destroy(Attendance $attendance)
    {
        //
    }
}
