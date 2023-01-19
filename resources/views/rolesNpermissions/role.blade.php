@extends('adminlte::page')

@section('title', 'Roles List')


@section('content_header')
    <h1>Roles List</h1>
@stop

@section('content')
    <p>Welcome to the Roles List Page</p>

    @if (!empty(session('success')))       
    <div class="alert alert-success">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        {{ Session::get('success') }}
    </div>
    @endif
    <button type='button' data-toggle='modal' data-target='#exampleModalCenter' class="btn btn-danger">Add Roles</button>
    <form action="{{ route('storeRole') }}" method="POST">
    @csrf
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Add Roles</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Role Name</label>
                            <input type="text" class="form-control" id="name" name='name' aria-describedby="emailHelp" placeholder="Enter name">
                        </div>
                    </div>
                    <div class="form-check m-2">
                        @foreach ($permissions as $permission)
                            
                        <input class="form-check-input" type="checkbox" value="{{ $permission->name }}" id="permissions" name="permissions[]">
                        <label class="form-check-label" for="permissions">
                            {{ $permission->name }}
                        </label>
                        <br>
                        @endforeach
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <div class="content">
        <div class="mt-3 pt-2">
            <table class="table table-borderless">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Permissions</th>
                        <th scope="col">Action</th>
                      </tr>
                    </thead>
                </thead>
                <tbody>
                    
                    @foreach ($roles as $role)
                    <tr>
                        
                          <th scope="row">{{ $loop->iteration }}</th>
                          <td>{{ $role->name }}</td>
                          <td>{{ $role->permissions->pluck('name') }}</td>
                          <td class="d-flex">
                            <form action="{{ route('destroyRole', $role->id) }}" method="POST">
                                @csrf
                                @method("DELETE")
                                <button type="submit" class="btn btn-outline-danger">Delete</button>
                            </form>
                            <button type='button' data-toggle='modal' data-target='#exampleModalCenter{{ $role->id }}' class="btn btn-outline-success mb-3">Edit</button>
                            <form action="{{ route('editRole', $role->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                    <div class="modal fade" id="exampleModalCenter{{ $role->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLongTitle">Edit {{ $role->name }} Role</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label for="exampleInputName">Name</label>
                                                        <input type="text" class="form-control" id="name" name='name' aria-describedby="nameHelp" placeholder="Enter Role Name " value="{{ $role->name }}">
                                                    </div>
                                                    <label for="exampleInputName">Permissions</label><br>
                                                    <div class="dropdown">
                                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        Permissions
                                                        </button>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                            <div class="form-check m-2">
                                                                    @foreach ($permissions as $permission)
                                                                        <input type="checkbox" class="form-check-input" value="{{ $permission->name }}" name="permissions[]">
                                                                        <label for="permissions">{{ $permission->name }}</label>
                                                                        <br>
                                                                    @endforeach
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

@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
<script> console.log('Hi!'); </script>
@stop