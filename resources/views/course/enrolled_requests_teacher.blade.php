@extends('adminlte::page')

@section('title', 'Enrollement Requests')


@section('content_header')
    <h1>Enrollement Requests</h1>
@stop

@section('content')
    <p>Welcome to the Enrollement Requests Page</p>

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

    <div class="content">
        <div class="mt-3 pt-2">
                        
            <table class="table table-borderless">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Course Code</th>
                    <th scope="col">Section</th>
                    <th scope="col">Teacher</th>
                    <th scope="col">Credit Count</th>
                    <th scope="col">Timing</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                        @foreach ($courses as $course)
                        <tr>
                            <th scope='row'>{{ $loop->iteration }}</th>
                            <td>{{ $course->section->course->name}}</td>
                            <td>{{ $course->section->section_id }}</td>
                            <td>{{ isset($course->teacher) ? $course->teacher->name : 'TBA' }}</td>
                            <td>{{ $course->section->course->credit_count }}</td>
                            <td>{{ $course->section->starting_time }} - {{ $course->section->ending_time }}</td>
                            <td>
                                <a href="{{ route('approve_enrollement_request', $course->id) }}" class="btn btn-success">Approve</a>
                                {{-- <a href="{{ route('reject_enrollement_request', $course->id) }}" class="btn btn-danger">Reject</a> --}}
                                <!-- Button trigger modal -->
                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal{{ $course->id }}">
                                Reject
                            </button>
                            
                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal{{ $course->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Are you sure you wanna reject the student?</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('reject_enrollement_request', $course->id) }}">
                                            <label for="reason" class="form-control">Reason for Rejection</label>
                                            <input type="text" name="reason" class="form-control">
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary">Save changes</button>
                                    </div>
                                </div>
                                </div>
                            </div>
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
