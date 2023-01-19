<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $courses = Course::with('preRequisite')->get();
        $departments = Department::all();

        return view('course.index', compact("courses", 'departments'));
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
            'credit_count' => 'required',
            'department_id' => 'required',
        ]);

        $user = Auth::user()->can('add_course');

        if (!$user)
            return back()->with("You're not an Admin");

        Course::create([
            'name' => $request->name,
            'abbr' => $request->name,
            'pre_req' => $request->pre_req != 0 ? $request->pre_req : NULL,
            'credit_count' => $request->credit_count,
            'require_lab' => $request->require_lab == 'on' ? 1 : 0,
            'parent_course' => $request->parent_course == 'Select a Course' ? NULL : $request->parent_course,
            'department_id' => $request->department_id
        ]);

        return back()->with('success', 'Successfully created a course');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function show(Course $course)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function edit(Course $course)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Course $course)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {
        //
    }
}
