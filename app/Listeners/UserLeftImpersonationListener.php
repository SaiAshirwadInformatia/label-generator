<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UserLeftImpersonationListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {

        activity("users")
            ->performedOn($event->impersonated)
            ->causedBy($event->impersonator)
            ->event("logout")
            ->log("left_impersonation");
    }
}
