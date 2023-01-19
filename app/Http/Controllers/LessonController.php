<?php

namespace App\Http\Controllers;

use App\Models\ClassModule;
use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LessonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function getLesson($id)
    {
        $classModule = ClassModule::where('id', $id)
            ->with('section', 'announcement', 'module', 'lesson')
            ->first();

        if (!isset($classModule)) return back();

        $lessons = Lesson::where('class_id', $id)
            ->get();

        return view('lesson.index', ['classModule' => $classModule, 'lessons' => $lessons]);
    }

    public function getDeletedLessons($id)
    {
        $classModule = ClassModule::where('id', $id)
            ->with('section', 'announcement', 'module', 'lesson')
            ->first();

        if (!isset($classModule)) return back();

        $lessons = Lesson::where('class_id', $id)
            ->onlyTrashed()
            ->get();

        return view('lesson.deleted', compact('classModule', 'lessons'));
    }

    public function restoreLesson($id)
    {
        Lesson::where('id', $id)->restore();
        return back()->with('success', "Successfully restore the Lesson");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'text_area' => 'required',
            'attachment' => 'mimes:pdf'
        ]);

        Lesson::create([
            'class_id' => $request->class_id,
            'title' => $request->title,
            'text_area' => $request->text_area,
            'downloadable_content' => $request->file('attachment') ? $request->file('attachment')->store('public/lessons/' . $request->class_id . '/') : NULL
        ]);

        return back()->with('success', 'Successfully posted the announcement ');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $lesson = Lesson::where('id', $id)
            ->with('class')
            ->first();

        if (isset($lesson->downloadable_content)) {
            $attachment = Storage::url($lesson->downloadable_content);
            return view('lesson.show', ['lesson' => $lesson, 'attachment' => $attachment]);
        }
        return view('lesson.show', ['lesson' => $lesson]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function edit(Lesson $lesson)
    {
        return $lesson;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        $lesson = Lesson::where('id', $id)
            ->first();

        if (!isset($lesson)) return back()->with('error', 'No lesson found');

        $lesson->update([
            'class_id' => $lesson->class_id,
            'title' => $request->title,
            'text_area' => $request->text_area,
            'downloadable_content' => $request->file('attachment') ? $request->file('attachment')->store('public/lessons/' . $request->class_id . '/') : NULL
        ]);

        return back()->with('success', "Successfully updated the lesson");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Lesson::where('id', $id)->delete();

        return back()->with('success', 'Successfully deleted the Lesson');
    }
}
