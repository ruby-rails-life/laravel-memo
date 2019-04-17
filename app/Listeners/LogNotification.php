<?php

namespace App\Listeners;

use Illuminate\Notifications\Events\NotificationSent;

class LogNotification
{
    /**
     * イベントリスナ生成
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * イベントの処理
     *
     * @param  \Illuminate\Notifications\Events\NotificationSent $event
     * @return void
     */
    public function handle(NotificationSent $event)
    {
        // $event->channel
        // $event->notifiable
        // $event->notification
        // $event->response
        \Log::Info('[from LogNotification]:' . $event->channel);
    }
}