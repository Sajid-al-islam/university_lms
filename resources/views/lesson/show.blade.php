@extends('adminlte::page')

@section('title', 'Class Lessons Page')

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
                <a href="{{ route('class.show',$lesson->class_id) }}" class="nav-link {{ (request()->route()->uri == 'dashboard/class/{class}') ? 'active' : '' }} link-dark" aria-current="page">
                    <svg class="bi me-2" width="16" height="16">
                        <use xlink:href="#home"></use>
                    </svg>
                    Home
                </a>
            </li>
            <li class="nav-item mb-2">
                <a href="{{ route('showAnnouncement', $lesson->class_id) }}" class="nav-link {{ (request()->route()->uri == 'dashboard/announcement/{announcement}') ? 'active' : '' }} link-dark" aria-current="page">
                    <svg class="bi me-2" width="16" height="16">
                        <use xlink:href="#home"></use>
                    </svg>
                    Announcement
                </a>
            </li>

            <li>
                <a href="{{ route('getLesson', $lesson->class_id) }}" class="nav-link link-dark {{ (request()->route()->uri == 'dashboard/lesson/{lesson}') ? 'active' : '' }}">
                    <svg class="bi me-2" width="16" height="16">
                        <use xlink:href="#table"></use>
                    </svg>
                    Class Lessons
                </a>
            </li>
            @if(isset($classModule))
            <li>
                <a href="{{ route('jitsi', $classModule->id) }}" class="nav-link link-dark {{ (request()->route()->uri == 'dashboard/people/{people}') ? 'active' : '' }}">
                    <svg class="bi me-2" width="16" height="16">
                        <use xlink:href="#grid"></use>
                    </svg>
                    Join Class
                </a>
            </li>
            @endif
        </ul>

    </div>

    <div class="container-fluid h-100">

        {{-- <h1 class="blockquote">{{ $lesson[0]->course->name }}.{{ $classModule->section->section_id }} Class</h5> --}}

        {{-- if the user is a teacher then user can add an annoucement --}}
        {{-- @if($classModule->section->teacher->user_id == Auth::id()) --}}

        {{-- --}}
        {{-- @endif --}}

        @if($lesson->class->section->teacher_id == Auth::id())
            <div class="pt-4">
                <button type='button' data-toggle='modal' data-target='#exampleModalCenter1' class="btn btn-danger">Edit Lesson</button>

                <form action="{{ route('lesson.update', $lesson->id) }}" method="POST" enctype="multipart/form-data">
                    @method('PUT')
                    @csrf
                    <div class="modal fade" id="exampleModalCenter1" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLongTitle">Edit Lesson</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group my-auto">
                                        <label for="exampleFormControlTitle1">Title</label>
                                        <input type="text" name="title" class="form-control" placeholder="Enter Title" value="{{ $lesson->title }}">
                                        <label for="exampleFormControlTextarea3">Content</label>
                                        <textarea class="form-control" id="exampleFormControlTextarea3" rows="5" name="text_area">{{ $lesson->text_area }}</textarea>
                                        <div class="d-flex justify-content-between">
                                            <input type="file" name="attachment" class="form-control" value="{{ $lesson->downloadable_content }}">
                                        </div>
                                        <input type="hidden" name="class_id" value="{{ $lesson->class_id }}">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Edit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            @endif

            <div class="container-fluid mt-3">

                <div class="bg-light text-black-50">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-img-top bg-danger">
                                <p class="text-danger">.</p>
                            </div>
                            <h3 class="card-title mb-2">
                                <b>{{ $lesson->title }}</b>
                            </h3>

                            <p class="card-text mt-3">- {{ $lesson->text_area }}</p>

                            @if (!empty($lesson->downloadable_content))
                            <a href="{{ url(Storage::url($lesson->downloadable_content)) }}">Attachment</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

    </div>
</main>

@stop

@section('footer')
<p> All rights reserved by {{ env('DEV_NAME') }} from 2021 to {{ date('Y') }} </p>
@stop