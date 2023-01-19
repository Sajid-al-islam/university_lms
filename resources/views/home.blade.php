 @extends('adminlte::page')

 @section('title', 'Dashboard')
 
 @section('content_header')
     <h1>Dashboard</h1>
 @stop
 
 @section('content')

    @if (!empty(session('error')))       
    <div class="alert alert-danger">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        {{ Session::get('error') }}
    </div>
    @endif

     <p>Welcome {{ Auth::user()->name }}.</p>
    <div style="display: flex;">
        @forelse ($classModules as $class)
            {{-- @dd($class->section->student_courses) --}}
            <div style="width: 18rem; margin: 1rem; min-height: 72vh">
                <div class="card">
                    <img class="card-img-top" src="https://singlecolorimage.com/get/ff{{ mt_rand(1111,9999) }}/400x150" alt="Card image cap">
                    <div class="card-body">
                        <a href="{{ route('class.show',$class->id) }}" class="text-decoration-none">
                            <b><h5 class="card-title">{{ $class->section->course->name }}.{{ $class->section->section_id }}</h5></b>
                        </a>
                            <br> <hr>
                            
                            <p class="card-text">Teacher: {{ $class->section->teacher->name }}</p>
                            <p class="card-text">Class Time: {{ $class->section->starting_time }} - {{ $class->section->ending_time }}</p>
                            

                    </div>
                </div>
            </div>
            @empty
            <h4 class="content text-center">OOps, Looks like you don't have any courses this semester</h4>
        @endforelse 
    </div>
    
 @stop
 

 @section('footer')
    <div class="align-left">
        <p> All rights reserved  by {{ env('DEV_NAME') }} from 2021 to {{ date('Y') }} </p>
    </div>
 @stop

 
 @section('js')
     <script> console.log('Hi!'); </script>
 @stop