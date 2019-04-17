<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ProjectCreatedNotification extends Notification
{
    use Queueable;

    public $project;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($project)
    {
        $this->project = $project;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    //->from('test@example.com', 'Example')
                    ->error()
                    ->subject('Create Project')
                    ->line($this->project->project_name . 'が作成されました。')
                    ->action('My Action', url('/'));
                    //->line('Thank you for using our application!');
    
        // $arrProjectStatus = \Common::GetProjectStatus();
        // return (new MailMessage)->view(
        //     'project.notification', ['project' => $this->project, 'arrProjectStatus'=>$arrProjectStatus]
        // );
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
