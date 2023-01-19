@extends('adminlte::page')

@section('title', 'Teacher List')


@section('content_header')
    <h1>Teacher List</h1>
@stop

@section('content')
    <p>Welcome to the Teacher List Page</p>

    @if (!empty(session('success')))       
    <div class="alert alert-success">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        {{ Session::get('success') }}
    </div>
    @endif

    @if(Auth::user()->can('add_user'))
        <button type='button' data-toggle='modal' data-target='#exampleModalCenter' class="btn btn-danger">Add Teacher</button>
        <form action="{{ route('teacher.store') }}" method="POST">
        @csrf
            <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Add Teacher</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <div class="form-group">
                                    <label for="exampleInputName">Full Name*</label>
                                    <input type="text" class="form-control" id="name" name='name' aria-describedby="nameHelp" placeholder="Enter name" required>
                                    <label for="exampleInputEmail1">Email*</label>
                                    <input type="text" class="form-control" id="email" name='email' aria-describedby="emailHelp" placeholder="Enter email" required>
                                    <label for="exampleInputPassword">Password*</label>
                                    <input type="password" class="form-control" id="password" name='password'  placeholder="Enter password" required>
                                    <label for="exampleInputDesignation">Designation*</label>
                                    <input type="text" class="form-control" id="designation" name='designation'  placeholder="Enter designation" required>
                                    <label for="exampleInputName">Department*</label><br>
                                    <select class="form-select" aria-label="Default select example" id="department" name="department" required>
                                        <option selected>Select a Department</option>
                                            @foreach ($departments as $department)
                                                    <option value="{{ $department->id }}">{{ $department->name }} ({{ $department->abbr }})</option>
                                            @endforeach
                                    </select><br>
                                    <label for="exampleInputName">Courses <span class="text text-muted">(Optional)</span></label><br>
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                          Courses
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <div class="form-check m-2">
                                                @foreach ($courses as $course)
                                
                                                <input class="form-check-input" type="checkbox" value="{{ $course->id }}" id="courses" name="courses[]">
                                                <label class="form-check-label" for="courses">
                                                    {{ $course->name }}
                                                </label>
                                                <br>
                                                @endforeach
                                            </div>
                                        </div>
                                      </div>
                                </div>
                            </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                </div>
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
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Designation</th>
                        <th scope="col">Department</th>
                        <th scope="col">Courses</th>
                      </tr>
                    </thead>
                </thead>
                <tbody>
                    
                    @foreach ($teachers as $teacher)
                        <tr>
                          <th scope="row">{{ $loop->iteration }}</th>
                          <td>
                            <a href="{{ route('teacher.show', $teacher) }}">
                                {{ $teacher->name }}
                            </a>
                        </td>
                          <td>{{ $teacher->email }}</td>
                          @if (!isset($teacher->teacher))
                              <td> N/A </td>
                              <td> N/A </td>
                              <td> N/A </td>
                          @else
                              <td>{{ $teacher->teacher->designation }}</td>
                              <td>{{ $teacher->teacher->department_R->name }} ({{ $teacher->teacher->department_R->abbr }})</td>
                              @if (isset($teacher->teacher->course_R))
                                  <td> N/A </td>
                              @else
                                   <td>
                                    @foreach ($teacher->teacher->courses_R as $course)
                                        {{ $course->name }} {{ !$loop->last ? ',' : '' }}
                                    @endforeach
                                   </td>
                              @endif
                              @foreach ($teacher->teacher->courses_R as $course)
                                  
                              @endforeach
                          @endif
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