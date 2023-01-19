<?php

use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\ClassModuleController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CreditPriceController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\JitsiMeetController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RolesNPermissionController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\SemesterController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudentCourseEnrollmentController;
use App\Http\Controllers\TeacherController;
use App\Jobs\AnnouncementEmailJob;
use App\Models\Announcement;
use App\Models\Lesson;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    // return view('welcome');
    return redirect('/dashboard');
});

Auth::routes();

Route::prefix('/dashboard')->middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('profile', [ProfileController::class, 'index'])->name('profile');

    // Resource Controllers
    Route::resource('course', CourseController::class);
    Route::resource('section', SectionController::class);
    Route::resource('department', DepartmentController::class);
    Route::resource('student', StudentController::class);
    Route::resource('teacher', TeacherController::class);
    Route::resource('class', ClassModuleController::class);
    Route::resource('lesson', LessonController::class);
    Route::resource('announcement', AnnouncementController::class);
    Route::resource('module', ModuleController::class);
    Route::resource('attendance', AttendanceController::class);

    //Student Enrolled Courses
    Route::get('enrolled_course', [StudentCourseEnrollmentController::class, 'index']);

    //Drop Course
    Route::delete('enrolled_course/{course}', [StudentCourseEnrollmentController::class, 'dropCourse'])->name('dropCourse');

    //Get Student Courses Fee for the semester
    Route::get('enrolled_course/bill', [StudentCourseEnrollmentController::class, 'generateBill'])->name('generateBill');

    //Student Enrollement Requests
    Route::get('enrollement_request', [StudentCourseEnrollmentController::class, 'getEnrollementRequests'])->name('getEnrollementRequests');

    //Send Request for Student Enrollment for a Section
    Route::post('enrollement_request', [StudentCourseEnrollmentController::class, 'requestEnrollment'])->name('requestEnrollment');

    //Teacher => Student Enrollement Requests
    // Route::get('enrollement_request_teacher', [StudentCourseEnrollmentController::class, 'enrollement_request_teacher']);

    //Enrollement Request Accept
    Route::get('enrollement_request_teacher_accept/{id}', [StudentCourseEnrollmentController::class, 'enrollement_request_teacher_approve'])->name('approve_enrollement_request');
    Route::get('enrollement_request_teacher_reject/{id}', [StudentCourseEnrollmentController::class, 'enrollement_request_teacher_reject'])->name('reject_enrollement_request');

    //Get Announcements of a particular section
    Route::get('getAnnounement/{announcement}', [AnnouncementController::class, 'showAnnouncement'])->name('showAnnouncement');

    //Get Trashed Announcements
    Route::get('getDeletedAnnouncements/{announcement}', [AnnouncementController::class, 'getDeletedAnnouncements'])->name('deletedAnnouncements');

    //Restore Deleted Announcements
    Route::post('restoreAnnouncement/{announcement}', [AnnouncementController::class, 'restoreAnnouncement'])->name('restoreAnnouncement');

    //Get Lessons of a particular class
    Route::get('getLesson/{lesson}', [LessonController::class, 'getLesson'])->name('getLesson');

    //Get Trashed Lessons
    Route::get('getDeletedLessons/{lesson}', [LessonController::class, 'getDeletedLessons'])->name('getDeletedLessons');

    //Restore Deleted Lessons
    Route::post('restoreLesson/{lesson}', [LessonController::class, 'restoreLesson'])->name('restoreLesson');

    Route::get('assing_result/{id}', [ClassModuleController::class, 'get_courses_result'])->name('get_courses_result');

    Route::post('result/update_gpa',[ClassModuleController::class, 'updateGPA'])->name('updateGPA');
    
    //Connect to Jitsi Meet for online class
    Route::get('meet/{id}', [JitsiMeetController::class, 'getRoom'])->name('jitsi');
});

Route::prefix('admin')->middleware(['auth', 'permission:add_roles|view_roles'])->group(function () {

    // Get Roles & Permissions
    Route::get('roles', [RolesNPermissionController::class, 'getRoles'])->name('getRoles');
    Route::get('permissions', [RolesNPermissionController::class, 'getPermissions'])->name('getPermissions');

    // Store Roles & Permissions
    Route::post('roles', [RolesNPermissionController::class, 'storeRole'])->name('storeRole');
    Route::post('permissions', [RolesNPermissionController::class, 'storePermission'])->name('storePermission');

    // Edit roles
    Route::put('roles/{role}', [RolesNPermissionController::class, 'editRole'])->name('editRole');

    // Delete Role
    Route::delete('roles/{role}', [RolesNPermissionController::class, 'destroyRole'])->name('destroyRole');

    // Per credit costing settings Resource Controller
    Route::resource('credit_price', CreditPriceController::class);

    // Semester Resource Controller
    Route::resource('semester', SemesterController::class);
});


Route::get('/test/{name}', function ($name) {
    return view('meet.jitsi', ['roomName' => $name, 'email' => $name . "@gmail.com", 'name' => $name]);
});
