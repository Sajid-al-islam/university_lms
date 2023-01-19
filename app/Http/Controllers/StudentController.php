<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Semester;
use App\Models\Student;
use App\Models\User;
use App\Traits\GenerateStudentID;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    use GenerateStudentID;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private static $semester_id;

    public function __construct()
    {
        self::$semester_id = Semester::orderBy('id', 'desc')
            ->first()->id;
    }

    public function index()
    {
        $students = User::where('isTeacher', 0)
            ->whereHas('roles', function ($query) {
                return $query->where('name', '!=', 'Super Admin');
            })
            ->with('student', 'permissions')
            ->get();
        $departments = Department::all();

        return view('student.index', compact('students', 'departments'));
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
            'phone' => 'required',
            'department' => 'required',
        ]);

        $department_code = Department::find($request->department)->department_code;


        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'gender' => $request->gender
        ]);

        $student_id = $this->generateID($user->id, self::$semester_id, $department_code);

        Student::insert([
            'user_id' => $user->id,
            'student_id' => $student_id,
            'department_id' => $request->department,
            'semester_id' => self::$semester_id,
            'phone' => $request->phone,
        ]);

        $user->assignRole('Student');

        return back()->with('success', 'Succcessfully created a Student');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show(User $student)
    {
        $student = $student->where('id', $student->id)
            ->with('student')
            ->first();

        return view('student.show', ['student' => $student, 'departments' => Department::all()]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit(Student $student)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::where('id', $id)
            ->first();

        if (!isset($user)) return back()->with('error', 'No user found');

        $student = Student::where('user_id', $id)
            ->first();

        if (!isset($student)) return back()->with('error', 'No Student Found');

        $user = $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'gender' => $request->gender
        ]);

        $student = $student->update([
            'user_id' => $id,
            'department_id' => $request->department,
            'semester_id' => self::$semester_id,
            'phone' => $request->phone,
        ]);

        if (!isset($user)) return back()->with("error", 'Something went wrong');
        if (!isset($student)) return back()->with("error", 'Something went wrong');

        return back()->with('success', "Successfully updated the Student");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        //
    }
}
