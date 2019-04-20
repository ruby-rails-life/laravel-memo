<?php

namespace App\Mail;

use App\Project;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProjectCreatedMail extends Mailable //implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $project;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($project)
    {
        $this->project = $project;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $arrProjectStatus = \Common::GetProjectStatus();
        $image_path = "xxx";
        return $this->view('mail.project.created_mail')
                    ->with(['arrProjectStatus'=>$arrProjectStatus]);
                    //->text('mail.project.created_plain');
                    //->with(['arrProjectStatus'=>$arrProjectStatus, 'image_path' => $image_path]);
                    //->attach($image_path);
    }
}
