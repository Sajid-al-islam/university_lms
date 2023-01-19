@extends('adminlte::page')

@section('title', 'Class Lesson Page')

@section('content_header')
    <h1>{{ $classModule->section->course->name }}.{{ $classModule->section->section_id }} Class</h1>
@stop

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
        <a href="{{ route('showAnnouncement', $classModule->id) }}" class="nav-link {{ (request()->route()->uri == 'dashboard/announcement/{announcement}') ? 'active' : '' }} link-dark" aria-current="page">
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

    {{-- <h1 class="blockquote">{{ $classModule->section->course->name }}.{{ $classModule->section->section_id }} Class</h5> --}}

        @if($classModule->section->teacher_id == Auth::id())
    
        <ul class="nav nav-tabs mb-3">
          <li class="nav-item">
            <a class="nav-link {{ (request()->route()->uri == 'dashboard/getLesson/{lesson}') ? 'active' : '' }}" aria-current="page" href="{{ route('getLesson', $classModule->id) }}">Lessons</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ request()->route()->uri == 'dashboard/getDeletedLessons/{lesson}' ? 'active' : '' }}" aria-current="page" href="{{ route('getDeletedLessons', $classModule->id) }}">Deleted Lessons</a>
          </li>
        </ul>
        
        @endif
    
    {{-- if the user is a teacher then user can add an annoucement --}}
    @if($classModule->section->teacher_id == Auth::id())
      <button type='button' data-toggle='modal' data-target='#exampleModalCenter' class="btn btn-danger">Add Lesson</button>
  
      <form action="{{ route('lesson.store') }}" method="POST" enctype="multipart/form-data">
      @csrf
          <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                      <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLongTitle">Add Lesson</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                          </button>
                      </div>
                      <div class="modal-body">
                          <div class="form-group my-auto">
                                  <label for="exampleFormControlTitle1">Title</label>
                                  <input type="text" name="title" class="form-control" placeholder="Enter Title">
                                  <label for="exampleFormControlTextarea3">Content</label>
                                  <textarea class="form-control" id="exampleFormControlTextarea3" rows="5" name="text_area"></textarea>
                                  <div class="d-flex justify-content-between">
                                      <input type="file" name="attachment" class="form-control">
                                  </div>
                                  <input type="hidden" name="class_id" value="{{ $classModule->id }}">
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
    
    <div>
        @if (!isset($lessons))
            <div class="d-flex justify-content-md-center align-items-center vh-100">
                <h2 >No Lessons has been posted!</h2>
            </div>
        @else
            <ul class="list-group mt-5">
              @forelse ($lessons as $lesson)
                <form action="{{ route('lesson.destroy', $lesson->id) }}" method="POST">
                @csrf
                @method('DELETE')
                    <li class="list-group-item d-flex justify-content-between">
                        <div class="my-3">
                          <p class=""><a href="{{ route('lesson.show', $lesson->id) }}" class="text-decoration-none">{{ $lesson->title }}</a></p>
                          <footer class="blockquote-footer">{{ $lesson->text_area }}</footer>
                        </div>
                        <div>
                          @if (!empty($lesson->downloadable_content))
                          <a href="{{ url(Storage::url($lesson->downloadable_content)) }}">
                            <p class="badge badge-pill badge-danger">Attachment</p>
                          </a>
                            @if($classModule->section->teacher_id == Auth::id())
                            <button class="btn btn-outline-danger" type="submit">X</button>
                            @endif
                          @else
                            @if($classModule->section->teacher_id == Auth::id())
                            <button class="btn btn-outline-danger" type="submit">X</button>
                            @endif
                          @endif
                        </div>
                    </li>

                  </form>
                @empty

                <h3 class="text-center">No lessons Yet</h3>
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