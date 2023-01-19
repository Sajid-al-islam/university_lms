@extends('adminlte::page')

@section('title', 'Permissions List')


@section('content_header')
    <h1>Permissions List</h1>
@stop

@section('content')
    <p>Welcome to the Permissions List Page</p>

    @if (!empty(session('success')))       
    <div class="alert alert-success">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        {{ Session::get('success') }}
    </div>
    @endif
    <button type='button' data-toggle='modal' data-target='#exampleModalCenter' class="btn btn-danger">Add Permissions</button>
    <form action="{{ route('storePermission') }}" method="POST">
    @csrf
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Add Permissions</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Permission Name</label>
                            <input type="text" class="form-control" id="name" name='name' aria-describedby="emailHelp" placeholder="Enter name">
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

    <div class="content">
        <div class="mt-3 pt-2">
            <table class="table table-borderless">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                      </tr>
                    </thead>
                </thead>
                <tbody>
                    
                    @foreach ($permissions as $permission)
                        <tr>
                          <th scope="row">{{ $loop->iteration }}</th>
                          <td>{{ $permission->name }}</td>
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