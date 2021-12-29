<?php

namespace App\Observers;

use App\Mail\CanceledClass;
use App\Models\Classes;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ClassObserver
{
    /**
     * Handle the Classes "created" event.
     *
     * @param  \App\Models\Classes  $classes
     * @return void
     */
    public function created(Classes $classes)
    {
    }

    /**
     * Handle the Classes "updated" event.
     *
     * @param  \App\Models\Classes  $classes
     * @return void
     */
    public function updated(Classes $classes)
    {
    }

    /**
     * Handle the Classes "deleted" event.
     *
     * @param  \App\Models\Classes  $classes
     * @return void
     */
    public function deleted(Classes $classes)
    {
       
    }

    /**
     * Handle the Classes "restored" event.
     *
     * @param  \App\Models\Classes  $classes
     * @return void
     */
    public function restored(Classes $classes)
    {
        //
    }

    /**
     * Handle the Classes "force deleted" event.
     *
     * @param  \App\Models\Classes  $classes
     * @return void
     */
    public function forceDeleted(Classes $classes)
    {
        //
    }
}
