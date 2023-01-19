<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $departments = Department::with('teacher')->get();

        $teachers = User::where('isTeacher', 1)
            ->get();

        return view('department.index', compact('departments', 'teachers'));
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
        $user = Auth::user()->can('add_department');

        if (!$user) return back()->with('error', "You're not an Admin");

        Department::create([
            'name' => $request->name,
            'abbr' => $request->abbr,
            'chairman' => $request->chairman,
            'department_code' => $request->code
        ]);

        return back()->with('success', "Successfully created a Department");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function show(Department $department)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function edit(Department $department)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (!Auth::user()->can('add_department')) return back()->with('error', 'No department found');
        $department = Department::where('id', $id)
            ->first();

        $department = $department->update([
            'name' => $request->name,
            'abbr' => $request->abbr,
            'chairman' => $request->chairman,
            'department_code' => $request->code
        ]);

        if (!isset($department)) return back()->with('error', 'Something Went wrong');

        return back()->with('success', 'Successfully edited the Department');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function destroy(Department $department)
    {
        //
    }
}
