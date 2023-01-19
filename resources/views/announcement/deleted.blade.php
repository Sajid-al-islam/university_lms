@extends('adminlte::page')

@section('title', 'Class Announcement Page')

@section('content')

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
        <a href="{{ route('showAnnouncement', $classModule->id) }}" class="nav-link {{ (request()->route()->uri == ('dashboard/announcement/{announcement}' || 'dashboard/getAnnounement/{announcement}')) ? 'active' : '' }} link-dark" aria-current="page">
          <svg class="bi me-2" width="16" height="16"><use xlink:href="#home"></use></svg>
          Announcement
        </a>
      </li>
      <li>
        <a href="{{ route('getLesson', $classModule->id) }}" class="nav-link link-dark {{ (request()->route()->uri == 'dashboard/getLesson/{lesson}') ? 'active' : '' }}">
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
      
    </ul>
    
</div>

<div class="container-fluid h-100">

    <h1 class="blockquote">{{ $classModule->section->course->name }}.{{ $classModule->section->section_id }} Class</h5>

    <ul class="nav nav-tabs">
      <li class="nav-item">
        <a class="nav-link {{ request()->route()->uri == 'dashboard/getAnnouncement/{announcement}' ? 'active' : null }}" aria-current="page" href="{{ route('showAnnouncement', $classModule->id) }}">Announcements</a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ request()->route()->uri == 'dashboard/getDeletedAnnouncements/{announcement}' ? 'active' : null }}" aria-current="page" href="{{ route('deletedAnnouncements', $classModule->id) }}">Deleted Announcements</a>
      </li>
    </ul>
    
    <div>
        @if (!isset($announcements))
            <div class="d-flex justify-content-md-center align-items-center vh-100">
                <h2 >No Announcement has been made!</h2>
            </div>
        @else
            <ul class="list-group mt-5">
              @forelse ($announcements as $announcement)
                <form action="{{ route('restoreAnnouncement', $announcement->id) }}" method="POST">
                @csrf
                    <li class="list-group-item d-flex justify-content-between">
                        <div class="my-3">
                          <p class="">{{ $announcement->title }}</p>
                          <footer class="blockquote-footer">{{ $announcement->text_area }}</footer>
                        </div>
                        <div>
                          @if (!empty($announcement->downloadable_content))
                          <a href="{{ url(Storage::url($announcement->downloadable_content)) }}">
                            <p class="badge badge-pill badge-danger">Attachment</p>
                          </a>
                          <button class="btn btn-outline-success" type="submit">Restore</button>
                          @else
                          <button class="btn btn-outline-success" type="submit">Restore</button>
                          @endif
                        </div>
                    </li>

                  </form>
                @empty

                <h3 class="text-center">No Deleted Announcements Yet</h3>
                @endforelse
            </ul>
        @endif
    </div>
</div>
</main>

@stop

@section('footer')
   <p> All rights reserved  by {{ env('DEV_NAME') }} from 2021 to {{ date('Y') }} </p>
@stop