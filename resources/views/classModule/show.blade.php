@extends('adminlte::page')

@section('title', 'Class Page')

@section('content_header')
    <h1>{{ $classModule->section->course->name }}.{{ $classModule->section->section_id }} Page</h1>
@stop

@section('content')

<style>
  .overflowAuto {
  overflow-y: auto;
  max-height: 200px;
}
</style>

<main class="d-flex">

<div class="d-flex flex-column flex-shrink-0 p-3 bg-light vh-100" style="width: 280px;">
    <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
    </a>
    <hr>
    <ul class="nav nav-pills flex-column ">
      <li class="nav-item mb-2">
        <a href="{{ route('class.show',$classModule->id) }}" class="nav-link {{ (request()->route()->uri == 'dashboard/class/{class}') ? 'active' : '' }} link-dark" aria-current="page">
          <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"></use></svg>
          Home
        </a>
      </li>
      <li class="nav-item mb-2">
        <a href="{{ route('showAnnouncement', $classModule->id) }}" class="nav-link {{ (request()->route()->uri == 'dashboard/announcement/{announcement}') ? 'active' : '' }} link-dark" aria-current="page">
          <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"></use></svg>
          Announcement
        </a>
      </li>
      
      <li>
        <a href="{{ route('getLesson', $classModule->id) }}" class="nav-link link-dark {{ (request()->route()->uri == 'dashboard/lesson/{lesson}') ? 'active' : '' }}">
          <svg class="bi me-2" width="16" height="16"><use xlink:href="#table"></use></svg>
          Class Lessons
        </a>
      </li>
      <li>
        <a href="{{ route('jitsi', $classModule->id) }}" class="nav-link link-dark {{ (request()->route()->uri == 'dashboard/people/{people}') ? 'active' : '' }}">
          <svg class="bi me-2" width="16" height="16"><use xlink:href="#grid"></use></svg>
          Join Class
        </a>
      </li>
      @if (Auth::user()->isTeacher == 1)  
      <li>
        <a href="{{ route('get_courses_result', $classModule->id) }}" class="nav-link link-dark {{ (request()->route()->uri == 'assing_result/{id}') ? 'active' : '' }}">
          <svg class="bi me-2" width="16" height="16"><use xlink:href="#grid"></use></svg>
          Assign result
        </a>
      </li>
      @else
        <li>
          <a href="{{ route('get_courses_result', $classModule->id) }}" class="nav-link link-dark {{ (request()->route()->uri == 'assing_result/{id}') ? 'active' : '' }}">
            <svg class="bi me-2" width="16" height="16"><use xlink:href="#grid"></use></svg>
            Result
          </a>
        </li>
      @endif
    </ul>
    
</div>

<div class="container-fluid">
    
    <div class="card">
        <div class="card-title ml-3 pt-4"><h4>Announcements</h4></div><hr>
        <div class="card-body overflowAuto">
          <ol>
            @forelse ($classModule->announcement as $announcement)
              <li>
                <a href="{{ route('announcement.show',$announcement->id) }}" class="p-4 text-decoration-none">
                  {{ $announcement->title }}
                </a>
              </li>
            @empty
              <h4>No Announcement yet</h4>
            @endforelse
          </ol>
        </div>
        <div class="card-footer"></div>
    </div>
    <div class="card">
      <div class="card-title ml-3 pt-4"><h4>Lessons</h4></div><hr>
        <div class="card-body overflowAuto">
          <ol>
            @forelse ($classModule->lesson as $lesson)
              <li>
                <a href="{{ route('lesson.show',$lesson->id) }}" class="pl-2 text-decoration-none">
                  {{ $lesson->title }}
                </a>
              </li>
            @empty
              <h4>No Lessons yet</h4>
            @endforelse
          </ol>
        </div>
        <div class="card-footer"></div>
    </div>
    
</div>
</main>

@stop

@section('footer')
   <p> All rights reserved  by {{ env('DEV_NAME') }} from 2021 to {{ date('Y') }} </p>
@stop

<script>
  var overflowAuto = document.getElementsByClassName('overflowAuto')[0];

//Get the distance from the top and add 20px for the padding
var maxHeight = overflowAuto.getBoundingClientRect().top + 20;

overflowAuto.style.height = "calc(100vh - " + maxHeight + "px)"; 
</script>