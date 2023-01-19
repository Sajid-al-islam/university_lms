@extends('adminlte::page')

@section('title', 'Announcement Page')

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
                <a href="{{ route('class.show',$announcement->class_id) }}" class="nav-link {{ (request()->route()->uri == 'dashboard/class/{class}') ? 'active' : '' }} link-dark" aria-current="page">
                    <svg class="bi me-2" width="16" height="16">
                        <use xlink:href="#home"></use>
                    </svg>
                    Home
                </a>
            </li>
            <li class="nav-item mb-2">
                <a href="{{ route('showAnnouncement', $announcement->class_id) }}" class="nav-link {{ (request()->route()->uri == ('dashboard/announcement/{announcement}' || 'dashboard/getAnnounement/{announcement}')) ? 'active' : '' }} link-dark"
                  aria-current="page">
                    <svg class="bi me-2" width="16" height="16">
                        <use xlink:href="#home"></use>
                    </svg>
                    Announcement
                </a>
            </li>
            <li>
                <a href="{{ route('getLesson', $announcement->class_id) }}" class="nav-link link-dark {{ request()->route()->uri == 'dashboard/getLesson/{lesson}' ? 'active' : '' }}">
                    <svg class="bi me-2" width="16" height="16">
                        <use xlink:href="#table"></use>
                    </svg>
                    Class Lessons
                </a>
            </li>


            @if (isset($classModule))
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

    <div class="container-fluid">

        <h1 class="blockquote">{{ $announcement->class->section->course->name }}.{{ $announcement->class->section->section_id }} Class</h5>

            @if($announcement->class->section->teacher_id == Auth::id())
                <button type='button' data-toggle='modal' data-target='#exampleModalCenter' class="btn btn-danger mb-3">Edit Announcement</button>

                <form action="{{ route('announcement.update', $announcement->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLongTitle">Edit Announcement</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group my-auto">
                                        <label for="exampleFormControlTitle1">Title</label>
                                        <input type="text" name="title" class="form-control" placeholder="Enter Title" value='{{ $announcement->title }}'>
                                        <label for="exampleFormControlTextarea3">Content</label>
                                        <textarea class="form-control" id="exampleFormControlTextarea3" rows="5" name="text_area">{{ $announcement->text_area }}</textarea>
                                        <div class="d-flex justify-content-between">
                                            <input type="file" name="attachment" class="form-control" value='{{ $announcement->downloadable_content }}'>
                                        </div>
                                        <input type="hidden" name="class_id" value="{{ $announcement->class_id }}">
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

                <div class="bg-light text-black-50">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-img-top bg-danger">
                                <p class="text-danger">.</p>
                            </div>
                            <h3 class="card-title">
                                <b>{{ $announcement->title }}</b>
                            </h3>

                            <p class="card-text mt-3">- {{ $announcement->text_area }}</p>

                            @if (!empty($announcement->downloadable_content))
                            <a href="{{ url(Storage::url($announcement->downloadable_content)) }}">Attachment</a>
                            @endif
                        </div>
                    </div>
                </div>
    </div>
</main>

@stop

@section('footer')
<p> All rights reserved by {{ env('DEV_NAME') }} from 2021 to {{ date('Y') }} </p>
@stop