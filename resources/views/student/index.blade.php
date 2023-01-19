@extends('adminlte::page')

@section('title', 'Student List')


@section('content_header')
    <h1>Student List</h1>
@stop

@section('content')
    <p>Welcome to the Student List Page</p>

    @if (!empty(session('success')))       
    <div class="alert alert-success">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        {{ Session::get('success') }}
    </div>
    @endif
    @if (Auth::user()->can('add_user'))
        <button type='button' data-toggle='modal' data-target='#exampleModalCenter' class="btn btn-danger">Add Stduent</button>
        <form action="{{ route('student.store') }}" method="POST">
        @csrf
            <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Add Student</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="exampleInputName">Full Name*</label>
                                <input type="text" class="form-control" id="name" name='name' aria-describedby="nameHelp" placeholder="Enter name" required>
                                <label for="exampleInputEmail1">Email*</label>
                                <input type="text" class="form-control" id="email" name='email' aria-describedby="emailHelp" placeholder="Enter email" required>
                                <label for="exampleInputPassword">Password*</label>
                                <input type="password" class="form-control" id="password" name='password'  placeholder="Enter password" required>
                                <label for="exampleInputGender">Gender*  <span class="text-muted mb-0">Male/Female</span></label>
                                <input type="text" class="form-control" id="gender" name='gender'  placeholder="Enter gender" required>
                                <label for="exampleInputMobile">Phone*</label>
                                <input type="number" class="form-control" id="phone" name='phone'  placeholder="Enter phone" required>
                                <label for="exampleInputName">Department*</label><br>
                                <select class="form-select" aria-label="Default select example" id="department" name="department" required>
                                    <option selected>Select a Department</option>
                                        @foreach ($departments as $department)
                                                <option value="{{ $department->id }}">{{ $department->name }} ({{ $department->abbr }})</option>
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
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Phone</th>
                        <th scope="col">StudentID</th>
                        <th scope="col">Department</th>
                      </tr>
                    </thead>
                </thead>
                <tbody>
                    @foreach ($students as $student)
                            <tr>
                              <th scope="row">{{ $loop->iteration }}</th>
                              <td>
                                <a href="{{ route('student.show', $student) }}">
                                    {{ $student->name }}
                                </a>
                             </td>
                              <td>{{ $student->email }}</td>
    
                              @if (! isset($student->student))
                                  <td> N/A </td>
                                  <td> N/A </td>
                                  <td> N/A </td>
                              @else
                                <td>{{ $student->student->phone }}</td>
                                <td>{{ $student->student->student_id }}</td>
                                <td>{{ $student->student->department->name }}</td>
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