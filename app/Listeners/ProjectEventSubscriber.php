<?php

namespace App\Listeners;

class ProjectEventSubscriber
{
    public function onProjectUpdate($event) 
    {
        \Log::Info('[' . $event->project->project_name . ']プロジェクトが更新されました');
    }

    public function onProjectDelete($event) 
    {
        \Log::Info('[' . $event->project->project_name . ']プロジェクトが削除されました');
    }

    /**
     * 購読するリスナの登録
     *
     * @param  \Illuminate\Events\Dispatcher  $events
     */
    public function subscribe($events)
    {
        $events->listen(
            'App\Events\ProjectUpdated',
            'App\Listeners\ProjectEventSubscriber@onProjectUpdate'
        );

        $events->listen(
            'App\Events\ProjectDeleted',
            'App\Listeners\ProjectEventSubscriber@onProjectDelete'
        );
    }
}