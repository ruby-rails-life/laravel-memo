<?php

namespace App\Observers;

use Illuminate\Support\Facades\Log;
use App\Clover;

class CloverObserver
{
    /**
     * Handle the clover "created" event.
     *
     * @param  \App\Clover  $clover
     * @return void
     */
    public function created(Clover $clover)
    {
        Log::info('In CloverObserver:' . $clover->clover_name);
    }

    /**
     * Handle the clover "updated" event.
     *
     * @param  \App\Clover  $clover
     * @return void
     */
    public function updated(Clover $clover)
    {
        //
    }

    /**
     * Handle the clover "deleted" event.
     *
     * @param  \App\Clover  $clover
     * @return void
     */
    public function deleted(Clover $clover)
    {
        //
    }

    /**
     * Handle the clover "restored" event.
     *
     * @param  \App\Clover  $clover
     * @return void
     */
    public function restored(Clover $clover)
    {
        //
    }

    /**
     * Handle the clover "force deleted" event.
     *
     * @param  \App\Clover  $clover
     * @return void
     */
    public function forceDeleted(Clover $clover)
    {
        //
    }
}
