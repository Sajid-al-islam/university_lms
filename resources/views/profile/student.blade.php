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
                  
                      <div class="row">
                        <div class="col-lg-4">
                          <div class="card mb-4">
                            <div class="card-body text-center">
                              @if (Auth::user()->gender == 'male' || Auth::user()->gender == 'm' || Auth::user()->gender == 'Male' || Auth::user()->gender == 'M')
                                <img src="https://avatars.dicebear.com/v2/avataaars/example.svg?mode=exclude&top%5B%5D=longHair&topChance=80&hatColor%5B%5D=pastel&hatColor%5B%5D=pink&hatColor%5B%5D=red&hairColor%5B%5D=red&hairColor%5B%5D=pastel&accessoriesChance=10&facialHairChance=80&facialHairColor%5B%5D=red&facialHairColor%5B%5D=pastel&clothesColor%5B%5D=red&clothesColor%5B%5D=pink&eyes%5B%5D=hearts" alt="avatar"
                                class="rounded-circle img-fluid mx-auto" style="width: 150px;">
                              @else
                                <img src="https://avatars.dicebear.com/v2/avataaars/example.svg?top%5B%5D=longHair&top%5B%5D=hat&topChance=100&accessoriesChance=40&facialHairChance=0" alt="avatar"
                                class="rounded-circle img-fluid mx-auto" style="width: 150px;">
                              @endif
                              <h5 class="my-3">{{ Auth::user()->name }}</h5>
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
                                  <p class="text-muted mb-0">{{ Auth::user()->name }}</p>
                                </div>
                              </div>
                              <hr>
                              <div class="row">
                                <div class="col-sm-3">
                                  <p class="mb-0">Email</p>
                                </div>
                                <div class="col-sm-9">
                                  <p class="text-muted mb-0">{{ Auth::user()->email }}</p>
                                </div>
                              </div>
                              <hr>
                              <div class="row">
                                <div class="col-sm-3">
                                  <p class="mb-0">Gender</p>
                                </div>
                                <div class="col-sm-9">
                                  <p class="text-muted mb-0">{{ Auth::user()->gender }}</p>
                                </div>
                              </div>
                              <hr>
                              <div class="row">
                                <div class="col-sm-3">
                                  <p class="mb-0">User ID</p>
                                </div>
                                <div class="col-sm-9">
                                  <p class="text-muted mb-0">{{ $student->student_id }}</p>
                                </div>
                              </div>
                              <hr>
                              <div class="row">
                                <div class="col-sm-3">
                                  <p class="mb-0">Phone</p>
                                </div>
                                <div class="col-sm-9">
                                  <p class="text-muted mb-0">{{ $student->phone }}</p>
                                </div>
                              </div>
                              <hr>
                              <div class="row">
                                <div class="col-sm-3">
                                  <p class="mb-0">Department</p>
                                </div>
                                <div class="col-sm-9">
                                  <p class="text-muted mb-0">{{ $student->department->name }} ({{ $student->department->abbr }})</p>
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

