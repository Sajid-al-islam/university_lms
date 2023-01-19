@extends('adminlte::page')

@section('title', 'Class Page')

@section('content_header')
    <h1>{{ $classModule->section->course->name }}.{{ $classModule->section->section_id }} Page</h1>
@stop

@section('content')

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
        <a href="{{ route('announcement.show', $classModule->id) }}" class="nav-link {{ (request()->route()->uri == 'dashboard/announcement/{announcement}') ? 'active' : '' }} link-dark" aria-current="page">
          <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"></use></svg>
          Announcement
        </a>
      </li>
      <li>
        <a href="{{ route('module.show', $classModule->id) }}" class="nav-link link-dark {{ (request()->route()->uri == 'dashboard/module/{module}') ? 'active' : '' }}">
          <svg class="bi me-2" width="16" height="16"><use xlink:href="#speedometer2"></use></svg>
          Module
        </a>
      </li>
      <li>
        <a href="{{ route('lesson.show', $classModule->id) }}" class="nav-link link-dark {{ (request()->route()->uri == 'dashboard/lesson/{lesson}') ? 'active' : '' }}">
          <svg class="bi me-2" width="16" height="16"><use xlink:href="#table"></use></svg>
          Class Lessons
        </a>
      </li>
      {{-- <li>
        <a href="{{ route('people.show', $classModule->id) }}" class="nav-link link-dark {{ (request()->route()->uri == 'dashboard/people/{people}') ? 'active' : '' }}">
          <svg class="bi me-2" width="16" height="16"><use xlink:href="#grid"></use></svg>
          People
        </a>
      </li> --}}
      
    </ul>
    
</div>

<div class="container-fluid">

    
    
</div>
</main>

@stop

@section('footer')
   <p> All rights reserved  by Rahil from 2021 to {{ date('Y') }} </p>
@stop