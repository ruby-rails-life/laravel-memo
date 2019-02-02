<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class BmiCalServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind( //サービスコンテナにバインド
            'bmical', // キー名
            'App\Services\BmiCal' // クラス名
        );
    }
}
