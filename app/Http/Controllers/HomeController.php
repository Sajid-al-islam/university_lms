<?php

namespace App\Http\Controllers;

use App\Models\ClassModule;
use App\Models\Section;
use App\Models\StudentCourses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // return Section::whereHas('student_courses', function ($query) {
        //     return $query->where('user_id', Auth::user()->id);
        // })->get();

        // return Section::with('student_courses', 'teacher')->get();
            
        $classModules = ClassModule::whereHas('section', function ($query) {
            return $query->whereHas('student_courses', function ($query) {
                return $query->where('user_id', Auth::user()->id);
            })->orWhereHas('teacher', function ($query) {
                return $query->where('id', Auth::user()->id);
            });
        })->get(); 

        if (!isset($classModules)) return back()->with('error', "Don't have any course");
        // $classModules =  ClassModule::where('section_id', $section[0]->id)->get();
        
        return view('home', compact('classModules'));
    }
}
