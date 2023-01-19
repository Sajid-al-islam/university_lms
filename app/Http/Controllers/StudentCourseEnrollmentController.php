<?php

namespace App\Http\Controllers;

use App\Models\CreditPrice;
use App\Models\Section;
use App\Models\Semester;
use App\Models\Student;
use App\Models\StudentCourseRequest;
use App\Models\StudentCourses;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class StudentCourseEnrollmentController extends Controller
{
    private static $semester;

    public function __construct()
    {
        self::$semester = Semester::orderBy('id', 'desc')
            ->first();
    }

    public function index()
    {
        $courses = StudentCourses::where('user_id', Auth::user()->id)
            ->where('semester_id', self::$semester->id)
            ->with('student', 'section', 'semester')
            ->get();

        $total_price = $this->generateBill();

        return view('course.enrolled_courses', ['courses' => $courses, 'total_price' => $total_price, 'semester' => self::$semester]);
    }

    public function getEnrollementRequests()
    {
        $courses = StudentCourseRequest::where('user_id', Auth::user()->id)
            ->orWhere('teacher_id', Auth::user()->id)
            ->with('student', 'teacher', 'section')
            ->get();

        return view('course.enrolled_requests', compact('courses'));
    }

    public function enrollement_request_teacher()
    {
        $courses = StudentCourseRequest::where('teacher_id', Auth::user()->id)
            ->with('student', 'teacher', 'section')
            ->get();

        return view('course.enrolled_requests_teacher', compact('courses'));
    }

    public function enrollement_request_teacher_approve($id)
    {
        //user_id, section_id, semester_id, course_id;

        //finding the course_request by $id
        $course_request = StudentCourseRequest::find($id);

        //creating the student_courses list
        StudentCourses::create([
            'user_id' => $course_request->user_id,
            'section_id' => $course_request->section_id,
            'semester_id' => self::$semester->id,
            'course_id' => $course_request->course_id,
        ]);

        //calculate available seats in the section
        $section = Section::find($course_request->section_id);

        $section->update([
            'seats_available' => ($section->seats_available - 1)
        ]);

        //deleteing the existing request as it won't be required anymore
        $course_request->delete();

        return back()->with('success', 'Successfully Approved the Request');
    }

    public function enrollement_request_teacher_reject($id, Request $request)
    {
        $request->validate([
            'reason' => 'required | string'
        ]);

        $course_req = StudentCourseRequest::find($id);

        $course_req = $course_req->setReject($request->reason);

        return back()->with('error', 'Rejected the Request');
    }

    public function requestEnrollment(Request $request)
    {
        $section = Section::find($request->section_id);

        $teacher_id = $section->teacher_id;

        $course_id = $section->course_id;

        //check if the student is already enrolled in that section for the semester

        $courseExist = StudentCourses::where('semester_id', self::$semester->id)
            ->where('user_id', Auth::user()->id)
            ->where('course_id', $course_id)
            ->first();

        //check if the enrollement request has been declined

        $requestDeclined = StudentCourseRequest::where('semester_id', self::$semester->id)
            ->where('user_id', Auth::user()->id)
            ->where('section_id', $request->section_id)
            ->where('course_id', $course_id)
            ->where('isDeclined', 1)
            ->first();


        //check if the enrollement request exist for the same section
        $requestExist = StudentCourseRequest::where('semester_id', self::$semester->id)
            ->where('user_id', Auth::user()->id)
            ->where('section_id', $request->section_id)
            ->where('course_id', $course_id)
            ->where('isDeclined', 0)
            ->first();


        //check if the enrollement request exists for same course
        $requestExistForSameCourse = StudentCourseRequest::where('semester_id', self::$semester->id)
            ->where('user_id', Auth::user()->id)
            ->where('course_id', $course_id)
            ->where('semester_id', self::$semester->id)
            ->where('isDeclined', 0)
            ->first();

        if (!empty($courseExist)) return back()->with('error', "You've already enrolled in this Course for the semester");

        if (!empty($requestExist)) return back()->with('error', "You've already requested for this Section in this semester");

        if (!empty($requestExistForSameCourse)) return back()->with('error', "You've already requested for this Course on a different Section this semester");

        if (!empty($requestDeclined)) return back()->with('error', "You're request has been declined for this section. Please try next semester");

        //return with success if the request is good to go  | Observer should mail the details to the teacher!

        StudentCourseRequest::create([
            'user_id' => Auth::user()->id,
            'section_id' => $request->section_id,
            'semester_id' => self::$semester->id,
            'teacher_id' => ($teacher_id == null) ? 0 : $teacher_id,
            'course_id' => $course_id,
        ]);


        return back()
            ->with(
                'success',
                'Successfully Requested for course enrollment'
            );
    }

    public function generateBill()
    {
        $student_courses = StudentCourses::where('user_id', Auth::id())
            ->with('section')
            ->get();

        $credit_cost = CreditPrice::where('credit_count', 1)
            ->first();

        $total_price = 0;
        foreach ($student_courses as $course) {
            $total_price += ($course->section->course->credit_count * $credit_cost->cost_per_credit);
        }

        return $total_price;
    }

    public function dropCourse($id, Request $request)
    {
        if (Carbon::parse(self::$semester->semester_drop_date)->format('Y/m/d') >= Carbon::now()->format('Y/m/d')) {

            if (isset($request->password)) {
                $check = Hash::check($request->password, Auth::user()->password);
                if (!$check) {
                    return back()->with('error', "Incorrect Password");
                }
            }
            $course = StudentCourses::where('id', $id)->first();

            if (!isset($course)) {
                return back()->with('error', 'Course was not found');
            }

            $course = $course->delete();

            if ($course) {
                return back()->with("success", 'Successfully dropped the course');
            }
            return back()->with('error', 'Something went wrong');
        }
        return back()->with('error', "Course dropping date has been over");
    }
}
