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
#spinner-div {
  position: fixed;
  display: none;
  width: 100%;
  height: 100%;
  top: 0;
  left: 0;
  text-align: center;
  background-color: rgba(255, 255, 255, 0.8);
  z-index: 2;
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
          
    @if( Session::has("success") )
        <div class="alert alert-success alert-block" role="alert">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            {{ Session::get("success") }}
        </div>
    @endif
    
    @if (Auth::user()->isTeacher == 1)
    <div class="card">
        <div class="card-title ml-3 pt-4"><h4>Student lists by course</h4></div><hr>
        <div class="card-body">
            <div class="mt-3 pt-2">
                <table class="table table-borderless">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Course</th>
                            <th scope="col">GPA</th>
                            <th scope="col">Assign result</th>
                        </tr>
                    </thead>
            
                    <tbody>
                        @foreach ($students as $key => $student)    
                            <tr>
                                <th scope="row">{{ $key+1 }}</th>
                                <td>
                                    <a href="">
                                        {{ $student->name }}
                                    </a>
                                </td>
                                <td>
                                    {{ $student->email }}
                                </td>
                                <td>
                                    {{$classModule->section->course->name}}
                                </td>
                                <td>
                                    @foreach ($student->course_info as $item)
                                        @if ($item->grade != null)
                                        @php
                                            $result = $item->grade;
                                        @endphp
                                            {{ $item->grade }}
                                        @endif
                                    @endforeach
                                </td>
                                <td>
                                    <button type="button" class="btn btn-primary" onclick="showDetails({!! $key !!})">
                                        {{ isset($item->grade) ? 'Re assign' : 'Assign' }} Result
                                    </button>
                                </td>
                            </tr>
                        </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer"></div>
    </div>
    @else 
        <div class="card-body">
            <table class="table table-borderless">
                <thead>
                    <th>#</th>
                    <th>Name</th>
                    <th>semester</th>
                    <th>course</th>
                    <th>GPA</th>
                </thead>
                <tbody>
                    @foreach ($students as $key => $student)
                        
                        <tr>
                            <th scope="row">{{ $key+1 }}</th>
                            <td>
                                <a href="">
                                    {{ $student->name }}
                                </a>
                            </td>
                            <td>
                                @if(isset($student->course_info))
                                    {{ $student->course_info->semester->name }} 
                                @endif
                            </td>
                            <td>
                                {{ $classModule->section->course->name }}
                            </td>
                            <td>
                                @if(isset($student->course_info))
                                    {{ $student->course_info->grade }}
                                @else
                                    TBA
                                @endif
                            </td>
                        </tr>
                    
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
    
     <!-- Modal -->
     <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <table class="table table-borderless">
                    <thead>
                        <th>Name</th>
                        <th>semester</th>
                        <th>course</th>
                        <th>GPA</th>
                    </thead>
                    <tbody id="student_info_table">
                        
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
        </div>
    </div>
    
</div>
</main>

@stop

@section('footer')
   <p> All rights reserved  by {{ env('DEV_NAME') }} from 2021 to {{ date('Y') }} </p>
@stop
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    $('#spinner-div').hide();
    var overflowAuto = document.getElementsByClassName('overflowAuto')[0];

    //Get the distance from the top and add 20px for the padding
    var maxHeight = overflowAuto.getBoundingClientRect().top + 20;

    overflowAuto.style.height = "calc(100vh - " + maxHeight + "px)"; 
        
    function fireToast(icon="success", title="success") {
        const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        return Toast.fire({
            icon,
            title
        });
    }
       

    function showDetails(index) {
        let student_infos = {!! json_encode($students) !!}
        let student = student_infos[index]
        let table = ""
        // console.log(student_infos[index], index, student);
        student.course_info.forEach(element => {
            table = `
                <tr>
                    <td>${student.name}</td>
                    <td>${element.semester.name}</td>
                    <td>${element.single_course.name}</td>
                    <td>
                        <select id="gradelist" name="gpa" class="form-control">
                            <option value="...">Select GPA</option>
                            <option value="4">A+</option>
                            <option value="3.75">A</option>
                            <option value="3.50">A-</option>
                            <option value="3.25">B+</option>
                            <option value="3.00">B</option>
                            <option value="2.75">B-</option>
                            <option value="2.50">C+</option>
                            <option value="2.25">C</option>
                            <option value="2.00">D</option>
                            <option value="0">F</option>
                        </select>    
                    </td>
                    <td>
                        <button
                        data-user_id=${student.id}
                        data-semester_id=${element.semester.id}
                        data-course_id=${element.single_course.id}
                        data-section_id=${element.single_section.section_id}
                        type="button" onclick="updateGPA()" class="btn btn-success">
                            Assign GPA
                        </button>
                    </td>
                    <td>
                        <div id="spinner-div" class="pt-5">
                            <div class="spinner-border text-primary" role="status">
                            </div>
                        </div>
                    <td>
                </tr>
            `
        });
        $('#student_info_table').html(table);
        $('#exampleModal').modal('show');
        console.log(student_infos);
    }

    function updateGPA() {
        let data = {
            grade: gradelist.value,
            user_id: event.target.dataset.user_id,
            semester_id: event.target.dataset.semester_id,
            course_id: event.target.dataset.course_id,
            section_id: event.target.dataset.section_id,
        }
        
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#spinner-div').show();
        $.ajax({
            type:'POST',
            url:"{{ route('updateGPA') }}",
            data,
                success:function(data){
                    if(data.success) {
                        $('#spinner-div').hide();
                        $('#exampleModal').modal('hide');
                        location.reload();
                        fireToast("success", `${data.success}`);
                        // let alert = `<div class="alert alert-success">
                        //     <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        //     <span id="success-mssg">${data.success}</span>
                        // </div>`
                        // $("#form-alert").html(alert)
                    }else {
                        window.s_alert("error", "something went wrong");
                    }

                }
        });
    }
</script>