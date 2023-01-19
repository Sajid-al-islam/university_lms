@extends('adminlte::page')

@section('title', 'Enrolled Course List')


@section('content_header')
    <h1>Enrolled Course List</h1>
@stop

@section('content')
    <p>Welcome to the Enrolled Course List Page</p>
    
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

    <div class="d-flex justify-content-between">
        <a href="{{ route('generateBill') }}" class="btn btn-outline-danger p-2 my-2">Show Bill</a>
        <div>
            <h4>Total Bill:  <span class="text-green">{{ $total_price }}</span></h4>
        </div>
    </div>


    <div class="content">
        <div class="mt-3 pt-2">
                        
            <table class="table table-borderless">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Course Code</th>
                    <th scope="col">Section</th>
                    <th scope="col">Credit Count</th>
                    <th scope="col">Timing</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>

                  
                    @foreach ($courses as $course)
                    <tr>
                        <th scope='row'>{{ $loop->iteration }}</th>
                        <td>{{ $course->section->course->name }}</td>
                        <td>{{ $course->section->section_id }}</td>
                        <td>{{ $course->section->course->credit_count }}</td>
                        <td>{{ $course->section->starting_time }} - {{ $course->section->ending_time }}</td>
                        <td>
                            @if(\Carbon\Carbon::parse($semester->semester_drop_date)->format('Y/m/d') >=  \Carbon\Carbon::now()->format('Y/m/d'))
                            <button type='button' data-toggle='modal' data-target='#exampleModalCenter{{ $course->section->course->id }}' class="btn btn-outline-danger mb-3">Drop</button>
                            <form action="{{ route('dropCourse', $course->id) }}" method="POST">
                                @csrf
                                @method("DELETE")
                                <div class="modal fade" id="exampleModalCenter{{ $course->section->course->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLongTitle">Drop {{ $course->section->course->name }} . {{ $course->section->section_id }}</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="exampleInputName">Enter your Password</label>
                                                    <input type="password" class="form-control" id="name" name='password' aria-describedby="nameHelp" placeholder="Enter your password" required>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Send</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            @else
                                <button class="btn btn-outline-danger" disabled>Drop</button>
                            @endif
                        </td>
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