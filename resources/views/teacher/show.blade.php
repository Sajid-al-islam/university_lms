@extends('adminlte::page')

@section('title', 'Profile')

@section('content_header')
    <h1>Profile Page</h1>
@stop

@section('content')
    <p>Welcome to Profile Page</p>
    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <section style="background-color: #eee;">
                    <div class="container py-5">
                      <div class="row">
                        <div class="col">
                          <nav aria-label="breadcrumb" class="bg-light rounded-3 p-3 mb-4">
                            <ol class="breadcrumb mb-0">
                              <li class="breadcrumb-item"><a href="{{ route('home') }}">Dashboard</a></li>
                              <li class="breadcrumb-item active" aria-current="page">User Profile</li>
                            </ol>
                          </nav>
                        </div>
                      </div>
                    
                    @if(Auth::user()->can('add_user'))
                      <button type='button' data-toggle='modal' data-target='#exampleModalCenter1' class="btn btn-outline-success mb-3">Edit Info</button>
                    @endif

                      <div class="row">
                        <div class="col-lg-4">
                          <div class="card mb-4">
                            <div class="card-body text-center">
                              {{-- <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava3.webp" alt="avatar"
                                class="rounded-circle img-fluid mx-auto" style="width: 150px;"> --}}
                              @if ($teacher->gender == 'male' || $teacher->gender == 'm' || $teacher->gender == 'Male' || $teacher->gender == 'M')
                                <img src="https://avatars.dicebear.com/v2/avataaars/example.svg?mode=exclude&top%5B%5D=longHair&topChance=80&hatColor%5B%5D=pastel&hatColor%5B%5D=pink&hatColor%5B%5D=red&hairColor%5B%5D=red&hairColor%5B%5D=pastel&accessoriesChance=10&facialHairChance=80&facialHairColor%5B%5D=red&facialHairColor%5B%5D=pastel&clothesColor%5B%5D=red&clothesColor%5B%5D=pink&eyes%5B%5D=hearts" alt="avatar"
                                class="rounded-circle img-fluid mx-auto" style="width: 150px;">
                              @else
                                <img src="https://avatars.dicebear.com/v2/avataaars/example.svg?top%5B%5D=longHair&top%5B%5D=hat&topChance=100&accessoriesChance=40&facialHairChance=0" alt="avatar"
                                class="rounded-circle img-fluid mx-auto" style="width: 150px;">
                              @endif
                                {{-- @dd($student) --}}
                              <h5 class="my-3">{{ $teacher->name }}</h5>  
                              <p class="text-muted mb-1"></p>
                              
                            </div>
                          </div>
                        </div>
                        <div class="col-lg-8">
                          <div class="card mb-4">
                            <div class="card-body">
                              <div class="row">
                                <div class="col-sm-3">
                                  <p class="mb-0">Full Name</p>
                                </div>
                                <div class="col-sm-9">
                                  <p class="text-muted mb-0">{{ $teacher->name }}</p>
                                </div>
                              </div>
                              <hr>
                              <div class="row">
                                <div class="col-sm-3">
                                  <p class="mb-0">Email</p>
                                </div>
                                <div class="col-sm-9">
                                  <p class="text-muted mb-0">{{ $teacher->email }}</p>
                                </div>
                              </div>
                              <hr>
                              <div class="row">
                                <div class="col-sm-3">
                                  <p class="mb-0">Gender</p>
                                </div>
                                <div class="col-sm-9">
                                  <p class="text-muted mb-0">{{ $teacher->gender }}</p>
                                </div>
                              </div>
                              <hr>
                              <div class="row">
                                <div class="col-sm-3">
                                  <p class="mb-0">Designation</p>
                                </div>
                                <div class="col-sm-9">
                                  <p class="text-muted mb-0">{{ $teacher->teacher->designation }}</p>
                                </div>
                              </div>
                              <hr>
                              <div class="row">
                                <div class="col-sm-3">
                                  <p class="mb-0">Department</p>
                                </div>
                                <div class="col-sm-9">
                                  <p class="text-muted mb-0">{{ $teacher->teacher->department_R->name }} ({{ $teacher->teacher->department_R->abbr }})</p>
                                </div>
                              </div>
                              <hr>
                              <div class="row">
                                <div class="col-sm-3">
                                  <p class="mb-0">Conducting Courses</p>
                                </div>
                                <div class="col-sm-9">
                                
                                @if(isset($teacher->teacher->courses_R))
                                  @foreach ($teacher->teacher->courses_R as $course)
                                    <span class="text-muted mb-0">{{ $course->name }} {{ !$loop->last ? ',' : '' }}</span>
                                  @endforeach

                                @else
                                  <span class="text-muted mb-0">N/A</span>
                                @endif

                                </div>
                              </div>
                              <hr>
                            </div>
                          </div>
                          
                        </div>
                      </div>
                    </div>
                  </section>
        </div>
    </div>
    <form action="{{ route('teacher.update', $teacher->id) }}" method="POST">
        @csrf
        @method('PUT')
            <div class="modal fade" id="exampleModalCenter1" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">Add Teacher</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <div class="form-group">
                                    <label for="exampleInputName">Full Name*</label>
                                    <input type="text" class="form-control" id="name" name='name' aria-describedby="nameHelp" placeholder="Enter name" value="{{ $teacher->name }}">
                                    <label for="exampleInputEmail1">Email*</label>
                                    <input type="text" class="form-control" id="email" name='email' aria-describedby="emailHelp" placeholder="Enter email" value="{{ $teacher->email }}">
                                    <label for="exampleInputEmail1">Gender*</label>
                                    <input type="text" class="form-control" id="gender" name='gender' aria-describedby="genderHelp" placeholder="Enter gender" value="{{ $teacher->gender }}">
                                    <label for="exampleInputPassword">Designation*</label>
                                    <input type="text" class="form-control" id="designation" name='designation'  placeholder="Enter designation" value="{{ $teacher->teacher->designation }}">
                                    <label for="exampleInputName">Department*</label><br>
                                    <select class="form-select" aria-label="Default select example" id="department" name="department">
                                        <option selected>Select a Department</option>
                                            @foreach ($departments as $department)
                                                    <option value="{{ $department->id }}" {{ $teacher->teacher->department_R->id == $department->id ? 'selected' : '' }}>{{ $department->name }} ({{ $department->abbr }})</option>
                                            @endforeach
                                    </select><br>
                                    <label for="exampleInputName">Courses <span class="text text-muted">(Optional)</span></label><br>
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                          Courses
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <div class="form-check m-2">
                                              {{-- {{ isset($teacher->teacher->courses_R) ? ($teacher->teacher->courses_R[0]->id == $course->id ? 'checked') : '' }} --}}
                                                @foreach ($courses as $course)

                                                <input class="form-check-input" type="checkbox" value="{{ $course->id }}" id="courses" name="courses[]" @if(isset($teacher->teacher->courses_R)) 
                                                  @foreach ($teacher->teacher->courses_R as $teacher_courses)
                                                    {{ $teacher_courses->id == $course->id ? 'checked' : ''}}
                                                  @endforeach
                                                  @else
                                                    ''
                                                @endif>

                                                <label class="form-check-label" for="courses">
                                                    {{ $course->name }}
                                                </label>
                                                <br>
                                                @endforeach
                                            </div>
                                        </div>
                                      </div>
                                </div>
                            </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
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

