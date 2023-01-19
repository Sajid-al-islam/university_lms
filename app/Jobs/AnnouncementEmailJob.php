<?php

namespace App\Jobs;

use App\Mail\AnnouncementMailer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class AnnouncementEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $announcement;

    /**
     * Create a new job instance.
     *
     * @return void
     */


    public function __construct($announcement)
    {
        $this->announcement = $announcement;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // foreach ($this->announcement->class->section->student_courses as $student) {
        //     Mail::to($student->student->email)->queue(new AnnouncementMailer($this->announcement));
        // }

        $emails = [];

        foreach ($this->announcement->class->section->student_courses as $student) {
            array_push($emails, $student->student->email);
        }

        Mail::to('lutfe@gmail.com')
            ->cc($emails)
            ->queue(new AnnouncementMailer($this->announcement));
    }
}
