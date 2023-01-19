@extends('adminlte::page')

@section('title', 'Course List')


@section('content_header')
    <h1>Course List</h1>
@stop

@section('content')
    <p>Welcome to the Course List Page</p>

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


    @if (Auth::user()->can('add_course'))
        <button type='button' data-toggle='modal' data-target='#exampleModalCenter' class="btn btn-danger">Add Course</button>
        <form action="{{ route('course.store') }}" method="POST">
        @csrf
            <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Add Course</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="exampleInputName">Course Name*</label>
                                <input type="text" class="form-control" id="name" name='name' aria-describedby="section_idHelp" placeholder="Enter Course Name" required>
                                <label for="exampleInputEmail1">Pre Requisite</label>
                                <br>
                                <select class="form-select" aria-label="Default select example" id="pre_req" name="pre_req" required>
                                    <option selected value=0>Select a Course</option>
                                        @foreach ($courses as $course)
                                                <option value="{{ $course->id }}">{{ $course->name }}</option>
                                        @endforeach
                                </select>
                                <br>
                                <label for="exampleInputPassword">Department*</label>
                                <br>
                                <select class="form-select" aria-label="Default select example" id="department_id" name="department_id" required>
                                    <option selected>Select a Department</option>
                                        @foreach ($departments as $department)
                                                <option value="{{ $department->id }}">{{ $department->name }} ({{ $department->abbr }})</option>
                                        @endforeach
                                </select>
                                <br>
                                <label for="exampleInputGender">Credit Count*</label>
                                <input type="number" class="form-control" id="credit_count" name='credit_count'  placeholder="Enter Credit Count" required>
                                <input type="checkbox" class="form-check-input ml-1" id="exampleCheck1" name='require_lab'>
                                <label for="exampleCheck1" class="form-check-label ml-4">Lab Required*</label><br>
                                <label for="exampleInputName">Parent Course* <span class="text-muted"> (Ignore if it's not a lab course)</span></label><br>
                                <select class="form-select" aria-label="Default select example" id="parent_course" name="parent_course" required>
                                    <option selected id="disableSelectInput">Select a Course</option>
                                        @foreach ($courses as $course)
                                                <option value="{{ $course->id }}">{{ $course->name }}</option>
                                        @endforeach
                                </select>
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
                    <th scope="col">Course PreRequisite</th>
                    <th scope="col">Credit Count</th>
                    <th scope="col">Require Lab</th>
                  </tr>
                </thead>
                <tbody>

                  
                    @foreach ($courses as $course)
                    <tr>

                        <th scope='row'>{{ $loop->iteration }}</th>
                        <td>{{ $course->name }}</td>
                        <td>{{$course->pre_req ? $course->preRequisite->name : 'N/A'}}</td>
                        <td>{{ $course->credit_count }}</td>
                        <td>{{ $course->require_lab ? 'Yes' : 'No'}}</td>
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