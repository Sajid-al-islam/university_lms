<?php

namespace App\Http\Controllers;

use App\Mail\ResultMail;
use App\Models\ClassModule;
use App\Models\Course;
use App\Models\Section;
use App\Models\StudentCourses;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ClassModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $teacher_exist = Auth::user()->teacher->id;

        $teacher_exist_in_section = Section::where('teacher_id', $teacher_exist)->first();

        $student_exist_in_section = StudentCourses::where('user_id', Auth::user()->id)->first();

        $classModules = ClassModule::with('section', 'announcement', 'module', 'lesson')
            ->get();

        dd('test');
        if (!isset($classModule)) return back()->with('error', "No such class was found");

        foreach ($classModule->section as $section) {
            dd($section);
        }

        return view('class.index', compact('classModules'));
    }

    public function get_courses_result($id)
    {
        $class = ClassModule::where("id", $id)->with('section', function($q) {
            return $q->with('student_courses', function($q2) {
                return $q2->with(['students']);
            });
        })->first();

        if(Auth::user()->isTeacher == 0) {
            $students = [];
            foreach ($class->section->student_courses as $key => $cstudents) {
                foreach ($cstudents->students as $key => $student) {
                    $course_info = StudentCourses::where('user_id', Auth::user()->id)->with(['semester', 'single_section', 'single_course'])->get();
                    $student->course_info = $course_info;
                    array_push($students, $student);
                }
            }
            $students = collect($students)->unique('id')->all();
        }else {
            $students = [];
            foreach ($class->section->student_courses as $key => $cstudents) {
                foreach ($cstudents->students as $key => $student) {
                    $course_info = StudentCourses::where('user_id', $student->id)->with(['semester', 'single_section', 'single_course'])->get();
                    $student->course_info = $course_info;
                    array_push($students, $student);
                }
            }
            $students = collect($students)->unique('id')->all();
        }
        

        // ddd(collect($students)->unique('id')->all());
        // dd($class->section->student_courses[0]->students);
        // ddd(collect($students)->unique('id')->all());
        

        $classModule =  ClassModule::where('id', $id)
            ->whereHas('section', function ($query) {
                return $query->whereHas('student_courses', function ($query2) {
                    return $query2->where('user_id', Auth::user()->id);
                })->orWhereHas('teacher', function ($query2) {
                    return $query2->where('id', Auth::user()->id);
                });
            })
            ->first();
        if (!isset($classModule)) return abort(403);

        $classModule = $classModule::where('id', $classModule->id)
            ->with('announcement', 'lesson')
            ->first();
        
        
        if (!isset($classModule)) return back()->with('error', "No such class was found");

        return view('classModule.courseResult', compact('classModule', 'students', 'class'));
    }

    public function updateGPA(Request $request)
    {
        $find_course = StudentCourses::where('semester_id', $request->semester_id)
        ->where('user_id', $request->user_id)
        ->where('course_id', $request->course_id)
        ->where('section_id', $request->section_id)
        ->update([
            "grade" => $request->grade
        ]);
        $course = Course::where('id', $request->course_id)->select('name')->first();

        $result = [
            "course" => $course->name,
            "result" => $request->grade
        ];

        $userMail = User::where('id', $request->user_id)->select('email')->first();
        $when = now()->addMinutes(1);
        
        Mail::to($userMail)->later($when, new ResultMail($result));

        $request->session()->flash('success', 'Result Assigned succcessfully.');

        return response()->json([
            'success' => 'Result Assigned successfully'
        ]);
        //function_body
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ClassModule  $classModule
     * @return \Illuminate\Http\Response
     */
    // public function show(ClassModule $classModule)
    // {
    //     return $classModule;
    // }

    public function show($id)
    {
        $classModule =  ClassModule::where('id', $id)
            ->whereHas('section', function ($query) {
                return $query->whereHas('student_courses', function ($query2) {
                    return $query2->where('user_id', Auth::user()->id);
                })->orWhereHas('teacher', function ($query2) {
                    return $query2->where('id', Auth::user()->id);
                });
            })
            ->first();
        if (!isset($classModule)) return abort(403);

        $classModule = $classModule::where('id', $classModule->id)
            ->with('announcement', 'lesson')
            ->first();

        if (!isset($classModule)) return back()->with('error', "You're not a member of this class");

        return view('classModule.show', compact('classModule'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ClassModule  $classModule
     * @return \Illuminate\Http\Response
     */
    public function edit(ClassModule $classModule)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ClassModule  $classModule
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ClassModule $classModule)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ClassModule  $classModule
     * @return \Illuminate\Http\Response
     */
    public function destroy(ClassModule $classModule)
    {
        //
    }
}
