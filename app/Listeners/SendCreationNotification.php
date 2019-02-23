<?php

namespace App\Listeners;

use App\Events\PostCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class SendCreationNotification //implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * ジョブを投入する接続名
     *
     * @var string|null
     */
    //public $connection = 'sqs';

    /**
     * ジョブを投入するキュー名
     *
     * @var string|null
     */
    //public $queue = 'listeners';

    /**
     * ジョブが処理開始されるまでの時間（秒）
     *
     * @var int
     */
    //public $delay = 60;

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
     * @param  \App\Events\PostCreated  $event
     * @return void
     */
    public function handle(PostCreated $event)
    {
        // if (true) {
        //     $this->release(30);
        // }
        Log::info('Post Created From SendCreationNotification:' . $event->post);
        // $event->postにより、注文へアクセス…
    }

    /**
     * 失敗したジョブの処理
     *
     * @param  \App\Events\OrderShipped  $event
     * @param  \Exception  $exception
     * @return void
     */
    public function failed(PostCreated $event, $exception)
    {
        //
    }
}