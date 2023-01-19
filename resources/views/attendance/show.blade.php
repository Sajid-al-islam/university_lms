@extends('adminlte::page')

@section('title', 'Section List')


@section('content_header')
    <h1>Section List</h1>
@stop

@section('content')
    <p>Welcome to the Section List Page</p>
    
    <div class="content">
        <div class="mt-3 pt-2">
            <table class="table table-borderless">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Student ID</th>
                        <th scope="col">Attended</th>
                        <th scope="col">Absent</th>
                    </tr>
                </thead>
                <tbody>
                    <tbody>
                        <form action="{{ route('attendance.store') }}" method="POST">
                            @csrf
                            @forelse ($students[0]->student_courses as $student)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td>{{ $student->student->name }}</td>
                                    <td>{{ $student->student->student->student_id }}</td>
                                    <td>
                                        <input type="checkbox" class="form-check-input ml-3" checked value=1 name="attendance[{{ $student->user_id }}]">
                                    </td>
                                    <td>
                                        <input type="checkbox" class="form-check-input ml-3" value="0" name="attendance[{{ $student->user_id }}]">
                                    </td>
                                    <input type="hidden" name="section_id" value="{{$students[0]->id}}">
                                </tr>
                                    
                            @empty
                                <h4 class="text-center">No Students enrolled in this class</h4>
                            @endforelse
                                    <button type="submit" class="btn btn-outline-success">Submit</button>
                        </form>
                    </tbody>
                </tbody>
            </table>
        </div>
    </div>
@stop

@section('footer')
   <p> All rights reserved  by {{ env('DEV_NAME') }} from 2021 to {{ date('Y') }} </p>
@stop

@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
<script> console.log('Hi!'); </script>
@stop

{{-- <td>{{ $student->student_courses[0]->student->name }}</td>
<td>{{ $student->student_courses[0]->student->student[0]->student_id }}</td>
<input type="hidden" value="{{ $student->id }}" name="section"> --}}
