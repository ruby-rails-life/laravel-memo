<?php

namespace App\Listeners;

use App\Events\ProjectCreated;

class CreateProjectNotification
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
     * @param  \App\Events\ProjectCreated  $event
     * @return void
     */
    public function handle(ProjectCreated $event)
    {
        // $event->orderにより、注文へアクセス…
        \Log::Info('[' . $event->project->project_name . ']プロジェクトが新規作成されました');
    }
}