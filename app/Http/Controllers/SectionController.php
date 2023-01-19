<?php

namespace App\Http\Controllers;

use App\Models\ClassModule;
use App\Models\Course;
use App\Models\Department;
use App\Models\Section;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index()
    {
        $sections = Section::with('course', 'teacher')->get();

        $chairman = Department::where('chairman', Auth::id())->first();

        // $teachers = Teacher::where('department', $chairman->id)
        //     ->with('user')
        //     ->get();
        if (isset($chairman)) {
            $courses = Course::where('department_id', $chairman->id)->get();

            $teachers = User::whereHas('teacher', function ($query) {
                return $query->where('department', Department::where('chairman', Auth::id())->first()->id);
            })->get();
            return view('section.index', compact('sections', 'chairman', 'courses', 'teachers'));
        } elseif (Auth::user()->hasAnyRole(['Super Admin', 'Admin'])) {
            $courses = Course::all();

            $teachers = User::where('isTeacher', 1)
                ->with('teacher')
                ->get();

            return view('section.index', ['courses' => $courses, 'sections' => $sections, 'teachers' => $teachers]);
        }

        return view('section.index', compact('sections'));
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
            'course_id' => 'required',
            'section_id' => 'required',
            'starting_time' => 'required',
            'ending_time' => 'required',
            'room_no' => 'required',
            'total_seats' => 'required',
        ]);


        $chairman = Department::where('chairman', Auth::id())->first();

        if (!Auth::user()->hasAnyRole(['Super Admin', 'Admin'])) {
            if (!isset($chairman)) return back()->with('error', "You're neither a Chairman nor an Admin");
        }

        $section = Section::create([
            'course_id' => $request->course_id,
            'section_id' => $request->section_id,
            'starting_time' => $request->starting_time,
            'ending_time' => $request->ending_time,
            'room_no' => $request->room_no,
            'total_seats' => $request->total_seats,
            'seats_available' => $request->total_seats,
            'teacher_id' => $request->teacher_id ? $request->teacher_id : null
        ]);

        if (!isset($section)) return back()->with('error', "Something went wrong");

        ClassModule::create([
            'section_id' => $section->id
        ]);

        return back()->with('success', 'Successfully Added a Section');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function show(Section $section)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function edit(Section $section)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Section $section)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Section  $section
     * @return \Illuminate\Http\Response
     */
    public function destroy(Section $section)
    {
        //
    }
}
