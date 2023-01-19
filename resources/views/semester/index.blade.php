@extends('adminlte::page')

@section('title', 'Semester List')


@section('content_header')
    <h1>Semester List</h1>
@stop

@section('content')
    <p>Welcome to the Department List Page</p>
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
      <button type='button' data-toggle='modal' data-target='#exampleModalCenter' class="btn btn-danger">Add Semester</button>
  
      <form action="{{ route('semester.store') }}" method="POST" enctype="multipart/form-data">
      @csrf
          <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                      <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLongTitle">Add Department</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                          </button>
                      </div>
                      <div class="modal-body">
                            <div class="form-group my-auto">
                                  <label for="exampleFormControlTitle1">Name*</label>
                                  <input type="text" name="name" class="form-control" placeholder="Enter Name" required>
                                  <label for="exampleFormControlTextarea3">Starting Date*</label>
                                  <input type="date" name="starting_date" class="form-control" placeholder="Enter Starting Date" required>
                                  <label for="exampleFormControlTextarea3">Ending Date*</label>
                                  <input type="date" name="ending_date" class="form-control" placeholder="Enter Ending Date" required>
                                  <label for="exampleFormControlTextarea3">Drop Date*</label>
                                  <input type="date" name="drop_date" class="form-control" placeholder="Enter Last date for dropping a course" required>

                            </div>
                          </div>
                          <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                              <button type="submit" class="btn btn-primary">Save</button>
                          </div>
                      </div>
                  </div>
              </div>
          
      </form>
    
            <table class="table table-borderless">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Starting Date</th>
                        <th scope="col">Ending Date</th>
                        <th scope="col">Course Drop Last Date</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($semesters as $semester)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $semester->name }}</td>
                            <td>{{ $semester->starting_date }}</td>
                            <td>{{ $semester->ending_date}}</td>
                            @if(isset($semester->semester_drop_date))
                                <td>{{ $semester->semester_drop_date }}</td>
                            @else
                                <td>TBA</td>
                            @endif
                            <td>
                                <button type='button' data-toggle='modal' data-target='#exampleModalCenter{{ $semester->id }}' class="btn btn-outline-success mb-3">Edit</button>
                            <form action="{{ route('semester.update', $semester->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                    <div class="modal fade" id="exampleModalCenter{{ $semester->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLongTitle">Edit {{ $semester->name }} Semester</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group my-auto">
                                                        <label for="exampleFormControlTitle1">Name*</label>
                                                        <input type="text" name="name" class="form-control" placeholder="Enter Name" value="{{ $semester->name }}">
                                                        <label for="exampleFormControlTextarea3">Starting Date*</label>
                                                        <input type="date" name="starting_date" class="form-control" placeholder="Enter Starting Date" value="{{ $semester->starting_date }}">
                                                        <label for="exampleFormControlTextarea3">Ending Date*</label>
                                                        <input type="date" name="ending_date" class="form-control" placeholder="Enter Ending Date" value="{{ $semester->ending_date }}">
                                                        <label for="exampleFormControlTextarea3">Drop Date*</label>
                                                        <input type="date" name="drop_date" class="form-control" placeholder="Enter Last date for dropping a course" value="{{ isset($semester->semester_drop_date) ?? ''  }}">                      
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

