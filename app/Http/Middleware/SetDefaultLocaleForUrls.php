<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Log;

class SetDefaultLocaleForUrls
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //URL::defaults(['locale' => $request->user()->locale]);
        
        $locale_before = \App::getLocale();   

        $lang = 'en';
        \App::setLocale($lang); 

        $locale_after = \App::getLocale();

        Log::info('From SetDefaultLocaleForUrls:' . ' [before]' . $locale_before . ' [after]'. $locale_after);
        return $next($request);
    }
}
