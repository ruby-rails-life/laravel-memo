<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        'App\Events\PostCreated' => [
            'App\Listeners\SendCreationNotification',
        ],
        'App\Events\ProjectCreated' => [
            'App\Listeners\CreateProjectNotification',
        ],
    ];

    /**
     * 登録する購読クラス
     *
     * @var array
     */
    protected $subscribe = [
        'App\Listeners\PostEventSubscriber',
        'App\Listeners\ProjectEventSubscriber',
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }

    // /**
    //  * イベントとリスナーを自動的に検出するか指定
    //  *
    //  * @return bool
    //  */
    // public function shouldDiscoverEvents()
    // {
    //     return true;
    // }
}
