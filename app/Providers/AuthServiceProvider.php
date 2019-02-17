<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
        //Post::class => PostPolicy::class,
        'App\Post' => 'App\Policies\PostPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
        // Auth::viaRequest('custom-token', function ($request) {
        //     return User::where('token', $request->token)->first();
        // });

        // Auth::provider('riak', function($app, array $config) {
        //     // Illuminate\Contracts\Auth\UserProviderのインスタンスを返す
        //     return new RiakUserProvider($app->make('riak.connection'));
        // });

        Gate::define('board.single', 'App\Policies\PostPolicy@view');
        Gate::define('admin', function($user){
            return $user->role == 1;
        });
    }
}
