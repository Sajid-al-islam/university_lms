@extends('adminlte::page')

@section('title', 'Section List')


@section('content_header')
    <h1>Attendace</h1>
@stop

@section('content')
    <p>Welcome to the Attendance Page</p>
    
    <div class="content">
        <div class="mt-3 pt-2">
            <table class="table table-borderless">
                <thead>
                    <tr>
                        <th scope="col">Lecture</th>
                        <th scope="col">Date</th>
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <tbody>
                        @forelse ($attendances as $attendance)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $attendance->created_at }}</td>
                                @if($attendance->attended)
                                    <td class="text-primary">YES</td>
                                @else
                                    <td class="text-danger">NO</td>
                                @endif
                            </tr>
                        @empty
                            <h4 class="text-center">No Lectures till date!</h4>
                        @endforelse
                    </tbody>
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

