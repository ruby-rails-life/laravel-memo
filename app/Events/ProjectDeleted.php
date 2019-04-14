<?php

namespace App\Events;

use App\Project;
use Illuminate\Queue\SerializesModels;

class ProjectDeleted
{
    use SerializesModels;

    public $project;

    /**
     * 新しいイベントインスタンスの生成
     *
     * @param  \App\Project  $project
     * @return void
     */
    public function __construct(Project $project)
    {
        $this->project = $project;
    }
}