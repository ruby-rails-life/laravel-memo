<?php

namespace App\Listeners;
use Illuminate\Support\Facades\Log;

class PostEventSubscriber
{
    public function onPostCreated($event) {
        Log::info('Post Created From PostEventSubscriber:' . $event->post);
    }
    
    /**
     * 購読するリスナの登録
     *
     * @param  \Illuminate\Events\Dispatcher  $events
     */
    public function subscribe($events)
    {
        $events->listen(
            'App\Events\PostCreated',
            'App\Listeners\PostEventSubscriber@onPostCreated'
        );
    }
}