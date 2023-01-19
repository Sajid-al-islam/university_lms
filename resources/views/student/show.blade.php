    @extends('adminlte::page')

    @section('title', 'Profile')
    
    @section('content_header')
        <h1>Profile Page</h1>
    @stop
    
    @section('content')
        <p>Welcome to Profile Page</p>
       
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
                                  @if ($student->gender == 'male' || $student->gender == 'm' || $student->gender == 'Male' || $student->gender == 'M')
                                    <img src="https://avatars.dicebear.com/v2/avataaars/example.svg?mode=exclude&top%5B%5D=longHair&topChance=80&hatColor%5B%5D=pastel&hatColor%5B%5D=pink&hatColor%5B%5D=red&hairColor%5B%5D=red&hairColor%5B%5D=pastel&accessoriesChance=10&facialHairChance=80&facialHairColor%5B%5D=red&facialHairColor%5B%5D=pastel&clothesColor%5B%5D=red&clothesColor%5B%5D=pink&eyes%5B%5D=hearts" alt="avatar"
                                    class="rounded-circle img-fluid mx-auto" style="width: 150px;">
                                  @else
                                    <img src="https://avatars.dicebear.com/v2/avataaars/example.svg?top%5B%5D=longHair&top%5B%5D=hat&topChance=100&accessoriesChance=40&facialHairChance=0" alt="avatar"
                                    class="rounded-circle img-fluid mx-auto" style="width: 150px;">
                                  @endif
                                  <h5 class="my-3">{{ $student->name }}</h5>
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
                                      <p class="text-muted mb-0">{{ $student->name }}</p>
                                    </div>
                                  </div>
                                  <hr>
                                  <div class="row">
                                    <div class="col-sm-3">
                                      <p class="mb-0">Email</p>
                                    </div>
                                    <div class="col-sm-9">
                                      <p class="text-muted mb-0">{{ $student->email }}</p>
                                    </div>
                                  </div>
                                  <hr>
                                  <div class="row">
                                    <div class="col-sm-3">
                                      <p class="mb-0">Gender</p>
                                    </div>
                                    <div class="col-sm-9">
                                      <p class="text-muted mb-0">{{ $student->gender }}</p>
                                    </div>
                                  </div>
                                  <hr>
                                  <div class="row">
                                    <div class="col-sm-3">
                                      <p class="mb-0">Student ID</p>
                                    </div>
                                    <div class="col-sm-9">
                                      <p class="text-muted mb-0">{{ $student->student->student_id }}</p>
                                    </div>
                                  </div>
                                  <hr>
                                  <div class="row">
                                    <div class="col-sm-3">
                                      <p class="mb-0">Phone</p>
                                    </div>
                                    <div class="col-sm-9">
                                      <p class="text-muted mb-0">{{ $student->student->phone }}</p>
                                    </div>
                                  </div>
                                  <hr>
                                  <div class="row">
                                    <div class="col-sm-3">
                                      <p class="mb-0">Department</p>
                                    </div>
                                    <div class="col-sm-9">
                                      <p class="text-muted mb-0">{{ $student->student->department->name }} ({{ $student->student->department->abbr }})</p>
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

        <form action="{{ route('student.update', $student->id) }}" method="POST">
            @csrf
            @method('PUT')
                <div class="modal fade" id="exampleModalCenter1" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Edit Student Info</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="exampleInputName">Full Name*</label>
                                    <input type="text" class="form-control" id="name" name='name' aria-describedby="nameHelp" placeholder="Enter name" value="{{ $student->name }}">
                                    <label for="exampleInputEmail1">Email*</label>
                                    <input type="text" class="form-control" id="email" name='email' aria-describedby="emailHelp" placeholder="Enter email" value="{{ $student->email }}">
                                    <label for="exampleInputGender">Gender*  <span class="text-muted mb-0">Male/Female</span></label>
                                    <input type="text" class="form-control" id="gender" name='gender'  placeholder="Enter gender" value="{{ $student->gender }}">
                                    <label for="exampleInputMobile">Phone*</label>
                                    <input type="number" class="form-control" id="phone" name='phone'  placeholder="Enter phone" value="{{ $student->student->phone }}">
                                    <label for="exampleInputName">Department*</label><br>
                                    <select class="form-select" aria-label="Default select example" id="department" name="department" value="{{ $student->student->department }}">
                                        <option selected value="{{ $student->student->department->id }}">Select a Department</option>
                                            @foreach ($departments as $department)
                                              <option value="{{ $department->id }}" {{ $student->student->department->id == $department->id ? 'selected' : '' }}>{{ $department->name }} ({{ $department->abbr }})</option>
                                            @endforeach
                                    </select>
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
    
    