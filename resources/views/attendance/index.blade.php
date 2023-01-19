@extends('adminlte::page')

@section('title', 'Section List')


@section('content_header')
    <h1>Section List</h1>
@stop

@section('content')
    <p>Welcome to the Section List Page</p>

    @if (!empty(session('success')))       
    <div class="alert alert-success">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        {{ Session::get('success') }}
    </div>
    @endif

    @if (!empty(session('error')))       
    <div class="alert alert-danger">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        {{ Session::get('error') }}
    </div>
    @endif
    @if (isset($chairman))
        <button type='button' data-toggle='modal' data-target='#exampleModalCenter' class="btn btn-danger">Add Section</button>
        <form action="{{ route('section.store') }}" method="POST">
        @csrf
            <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Add Section</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="exampleInputName">Section ID*</label>
                                <input type="text" class="form-control" id="name" name='section_id' aria-describedby="section_idHelp" placeholder="Enter section_id" required>
                                <label for="exampleInputEmail1">Course*</label>
                                <br>
                                <select class="form-select" aria-label="Default select example" id="course_id" name="course_id" required>
                                    <option selected>Select a Course</option>
                                        @foreach ($courses as $course)
                                                <option value="{{ $course->id }}">{{ $course->name }}</option>
                                        @endforeach
                                </select>
                                <br>
                                <label for="exampleInputPassword">Teacher*</label>
                                <br>
                                <select class="form-select" aria-label="Default select example" id="teacher_id" name="teacher_id" required>
                                    <option selected>Select a Teacher</option>
                                        @foreach ($teachers as $teacher)
                                                <option value="{{ $teacher->id }}">{{ $teacher->name }} ({{ $teacher->designation }})</option>
                                        @endforeach
                                </select>
                                <br>
                                <label for="exampleInputGender">Starting Time*  <span class="text-muted mb-0">Male/Female</span></label>
                                <input type="time" class="form-control" id="starting_time" name='starting_time'  placeholder="Enter starting_time" required>
                                <label for="exampleInputMobile">Ending Time*</label>
                                <input type="time" class="form-control" id="ending_time" name='ending_time'  placeholder="Enter ending_time" required>
                                <label for="exampleInputName">Room*</label><br>
                                <input type="text" class="form-control" name="room_no">
                                <label for="seats">Total Seats</label>
                                <input type="number" class="form-control" name='total_seats'>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    @endif
    <div class="content">
        <div class="mt-3 pt-2">
            <table class="table table-borderless">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Course Code</th>
                        <th scope="col">Section</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    
                        @csrf
                        @foreach ($sections as $section)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $section->course->name }}</td>
                            <td>{{ $section->section_id }}</td>
                            <td><a href="{{ route('attendance.show', $section->id) }}" class="btn btn-outline-success">Attendance</a></td>
                        </tr>
                        @endforeach
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