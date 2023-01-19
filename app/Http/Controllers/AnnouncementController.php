<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\ClassModule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AnnouncementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function showAnnouncement($id)
    {
        $classModule = ClassModule::where('id', $id)
            ->with('section', 'announcement', 'module', 'lesson')
            ->first();

        if (!isset($classModule)) return back();
        $announcements = Announcement::where('class_id', $id)
            ->with('class')
            ->orderBy('id', 'desc')
            ->get();


        return view('announcement.index', compact('classModule', 'announcements'));
    }

    public function getDeletedAnnouncements($id)
    {
        $classModule = ClassModule::where('id', $id)
            ->with('section', 'announcement', 'module', 'lesson')
            ->first();

        if (!isset($classModule)) return back();

        $announcements = Announcement::where('class_id', $id)
            ->onlyTrashed()
            ->with('class')
            ->get();

        return view('announcement.deleted', compact('classModule', 'announcements'));
    }

    public function restoreAnnouncement($id)
    {
        Announcement::where('id', $id)
            ->restore();

        return back()->with('success', 'Successfully restored the Announcement');
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
        
        $announcement = Announcement::create([
            'class_id' => $request->class_id,
            'title' => $request->title,
            'text_area' => $request->text_area,
            'downloadable_content' => $request->file('attachment') ? $request->file('attachment')->store('public/announcements/' . $request->class_id . '/') : NULL
        ]);

        // $attachment = Storage::put('public/announcements/' . $request->class_id . '/' . $announcement->id, $request->downloadable_content);

        return back()->with('success', 'Successfully posted the announcement ');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Announcement  $announcement
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $announcement = Announcement::where('id', $id)
            ->with('class')
            ->first();

        $attachment = Storage::url($announcement->downloadable_content);
        return view('announcement.show', compact('announcement', 'attachment'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Announcement  $announcement
     * @return \Illuminate\Http\Response
     */
    public function edit(Announcement $announcement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Announcement  $announcement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $announcement = Announcement::where('id', $id)
            ->first();

        if (!isset($announcement)) return back()->with('error', "No annoucement found");

        $announcement->update([
            'class_id' => $request->class_id,
            'title' => $request->title,
            'text_area' => $request->text_area,
            'downloadable_content' => $request->file('attachment') ? $request->file('attachment')->store('public/announcements/' . $request->class_id . '/') : NULL
        ]);

        return back()->with('success', 'Successfully updated the Announcement');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Announcement  $announcement
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Announcement::where('id', $id)
            ->delete();

        return back()->with('success', "Successfully deleted the announcement");
    }
}
