<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Department;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $teachers = User::where('isTeacher', 1)
            ->with('teacher')
            ->get();

        $courses = Course::all();

        $departments = Department::all();

        return view('teacher.index', compact('teachers', 'courses', 'departments'));
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
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'department' => 'required',
            'designation' => 'required',
        ]);


        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'isTeacher' => 1,
            'gender' => $request->gender,
        ]);

        $teacher = Teacher::create([
            'user_id' => $user->id,
            'department' => $request->department,
            'designation' => $request->designation,
        ]);

        $user->assignRole('Teacher');

        $courses = $request->courses;

        $teacher->courses_R()->attach($courses);
        $teacher->courses_R()->sync($courses);

        return back()->with('success', 'Succcessfully created a Teacher');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function show(User $teacher)
    {
        $teacher = $teacher->where('id', $teacher->id)
            ->with('teacher')
            ->first();


        $courses = Course::all();

        $departments = Department::all();

        return view('teacher.show', ['teacher' => $teacher, 'courses' => $courses, 'departments' => $departments]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function edit(Teacher $teacher)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $teacher)
    {

        if (!isset($teacher)) return back()->with('error', 'No user found');

        $teacher_info = Teacher::where('user_id', $teacher->id)
            ->first();

        if (!isset($teacher_info)) return back()->with('error', 'No teacher found');

        $teacher->update([
            'name' => $request->name,
            'email' => $request->email,
            'isTeacher' => 1,
            'gender' => $request->gender,
        ]);

        if (!isset($teacher)) return back()->with('error', 'Something went wrong');

        $teacher_info->update([
            'user_id' => $teacher->id,
            'department' => $request->department,
            'designation' => $request->designation,
        ]);


        $teacher_info->courses_R()->sync($request->courses);


        return back()->with('success', 'Successfully updated the info');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Teacher  $teacher
     * @return \Illuminate\Http\Response
     */
    public function destroy(Teacher $teacher)
    {
        //
    }
}
