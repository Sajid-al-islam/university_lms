@extends('adminlte::page')

@section('title', 'Credit Price Settings')

@section('content_header')
    <h4>Per Credit Price Settings</h4>
@stop

@section('content')
    <p>Welcome to Pre Credit Price Settings</p>

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
                    <th scope="col">Credit Count</th>
                    <th scope="col">Price</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                    <tr>
                        @if(!isset($creditPrice))
                            <h4 class="text-center">No Pricing has been set!</h4>
                            <br>
                            <button type='button' data-toggle='modal' data-target='#exampleModalCenter' class="btn btn-outline-danger mb-3">Set Pricing</button>
                        @else
                            <td>{{ $creditPrice->credit_count }}</td>
                            <td>{{ $creditPrice->cost_per_credit }}</td>
                            <td>
                            <button type='button' data-toggle='modal' data-target='#exampleModalCenter1' class="btn btn-outline-success mb-3">Edit</button>
                            </td>
                        @endif
                    </tr>
                </tbody>
              </table>
        </div>
        @if(isset($creditPrice))
        <form action="{{ route('credit_price.update', $creditPrice) }}" method="POST">
            @csrf
            @method('PUT')
                <div class="modal fade" id="exampleModalCenter1" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Edit Per Credit Pricing</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="exampleInputName">Price</label>
                                    <input type="number" class="form-control" id="name" name='price' aria-describedby="nameHelp" placeholder="Enter Credit Price" value="{{ $creditPrice->cost_per_credit }}">
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
        <form action="{{ route('credit_price.store') }}" method="POST">
            @csrf
                <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Set Per Credit Pricing</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="exampleInputName">Price</label>
                                    <input type="number" class="form-control" id="name" name='price' aria-describedby="nameHelp" placeholder="Enter Credit Price">
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
    </div>
@stop

@section('footer')
    <p> All rights reserved  by {{ env('DEV_NAME') }} from 2021 to {{ date('Y') }} </p>
@stop