<?php

namespace App\Listeners;

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
     * @param object $event
     *
     * @return void
     */
    public function handle($event)
    {
        activity('users')
            ->performedOn($event->impersonated)
            ->causedBy($event->impersonator)
            ->event('logout')
            ->log('left_impersonation');
    }
}
