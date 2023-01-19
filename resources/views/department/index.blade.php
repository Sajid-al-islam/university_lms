@extends('adminlte::page')

@section('title', 'Department List')


@section('content_header')
    <h1>Department List</h1>
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
    @if(Auth::user()->can('add_department'))
      <button type='button' data-toggle='modal' data-target='#exampleModalCenter' class="btn btn-danger">Add Department</button>
  
      <form action="{{ route('department.store') }}" method="POST" enctype="multipart/form-data">
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
                                  <input type="text" name="name" class="form-control" placeholder="Enter Name">
                                  <label for="exampleFormControlTextarea3">Abbreviation*</label>
                                  <input type="text" class="form-control" name="abbr" placeholder="Enter an Abbreviation">
                                  <label for="exampleFormControlName1">Department Code*</label>
                                  <input type="number" name="code" class="form-control" placeholder="Enter a unique Code">
                                  <label for="exampleFormControlName1">Chairman*</label><br>
                                  <select class="form-select" aria-label="Default select example" id="chairman" name="chairman" required>
                                    <option value=0>Select a Chairman</option>
                                        @foreach ($teachers as $teacher)
                                                <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                                        @endforeach
                                </select>

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
    
    @endif
            <table class="table table-borderless">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Abbreviation</th>
                        <th scope="col">Chairman</th>
                         @if (Auth::user()->can('add_department'))
                            <th scope="col">Department Code</th>
                            <th scope="col">Action</th>
                         @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach ($departments as $department)
                        <tr>
                            <form action="{{ route('department.update', $department->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                {{-- <th scope="row">{{ $loop->iteration }}</th> --}}
                                <th scope="row">{{ $department->id }}</th>
                                <td>{{ $department->name }}</td>
                                <td>{{ $department->abbr }}</td>
                                
                                @if ($department->chairman == null)
                                <td>TBA</td>
                                @else
                                <td>{{ $department->teacher->name }}</td>
                                @endif
                                @if (Auth::user()->can('add_department'))
                                <td>{{ $department->department_code }}</td>
                                <td>
                                    
                                    <button type='button' data-toggle='modal' data-target='#exampleModalCenter{{ $department->id }}' class="btn btn-outline-success">Edit</button>
                                    
                                    <div class="modal fade" id="exampleModalCenter{{ $department->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLongTitle">Edit Department {{ $department->abbr }}</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group my-auto">
                                                            <label for="exampleFormControlTitle1">Name*</label>
                                                            <input type="text" name="name" class="form-control" placeholder="Enter Name" value="{{ $department->name }}">
                                                            <label for="exampleFormControlTextarea3">Abbreviation*</label>
                                                            <input type="text" class="form-control" name="abbr" placeholder="Enter an Abbreviation" value="{{ $department->abbr }}">
                                                            <label for="exampleFormControlName1">Department Code*</label>
                                                            <input type="number" name="code" class="form-control" placeholder="Enter a unique Code" value="{{ $department->department_code }}">
                                                            <label for="exampleFormControlName1">Chairman*</label><br>
                                                            <select class="form-select" aria-label="Default select example" id="chairman" name="chairman">
                                                              <option value="0">Select a Chairman</option>
                                                                  @foreach ($teachers as $teacher)
                                                                          <option value="{{ $teacher->id }}" {{ $teacher->id == $department->chairman ? 'selected' : '' }}>{{ $teacher->name }}</option>
                                                                  @endforeach
                                                          </select>
                          
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Save</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                </td>
                                @endif
                            </form>
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