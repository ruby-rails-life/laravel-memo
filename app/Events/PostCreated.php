<?php

namespace App\Events;

use App\Post;
use Illuminate\Queue\SerializesModels;

class PostCreated
{
    use SerializesModels;

    public $post;

    /**
     * 新しいイベントインスタンスの生成
     *
     * @param  \App\Post  $post
     * @return void
     */
    public function __construct(Post $post)
    {
        $this->post = $post;
    }
}