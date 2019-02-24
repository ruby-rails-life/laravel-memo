<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Observers\CloverObserver;
use App\Clover;
use Illuminate\Support\Carbon;
use Illuminate\Http\Resources\Json\Resource;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Queue;
use Illuminate\Queue\Events\JobFailed;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        Blade::directive('datetime', function ($expression) {
            return "<?php echo ($expression)->format('m/d/Y H:i'); ?>";
        });

        DB::listen(function ($query) {
            // $query->sql
            // $query->bindings
            // $query->time
            $sql = $query->sql;
            for ($i = 0; $i < count($query->bindings); $i++) {
                $sql = preg_replace("/\?/", $query->bindings[$i], $sql, 1);
            }
            Log::info($sql);
        });

        Clover::observe(CloverObserver::class);

        //アプリケーション上のすべての日付と時刻が、Carbonによりどのようにシリアライズされるかをカスタマイズする
        // Carbon::serializeUsing(function ($carbon) {
        //     return $carbon->format('y');
        // });

        Resource::withoutWrapping();

        //デフォルトのペジネーションビューとして、他のファイルを指定したい場合
        //Paginator::defaultView('view-name');
        //Paginator::defaultSimpleView('view-name');

        // Queue::failing(function (JobFailed $event) {
        //     // $event->connectionName
        //     // $event->job
        //     // $event->exception
        // });

        // Queue::before(function (JobProcessing $event) {
        //     // $event->connectionName
        //     // $event->job
        //     // $event->job->payload()
        // });

        // Queue::after(function (JobProcessed $event) {
        //     // $event->connectionName
        //     // $event->job
        //     // $event->job->payload()
        // });

        // Queue::looping(function () {
        //     while (DB::transactionLevel() > 0) {
        //         DB::rollBack();
        //     }
        // });

        //全ビューに対し、一部のデータを共有
        View::share('myViewKey', 'myViewValue');

        View::composer('home', 
            'App\Http\View\Composers\MyComposer'
        );

        // View::composer('*', function ($view) {
        //     $view->with('count', Clover::count());
        // });

        Validator::extend('bar', function ($attribute, $value, $parameters, $validator) {
            return ($value != 'bar' && $value != 'BAR');
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
