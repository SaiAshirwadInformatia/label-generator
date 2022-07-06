<?php

namespace App\Providers;

use App\Events\LabelCreated;
use App\Listeners\GenerateLabelFields;
use App\Listeners\UserImpersonatedListener;
use App\Listeners\UserLeftImpersonationListener;
use App\Models\User;
use App\Observers\UserObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use Lab404\Impersonate\Events\LeaveImpersonation;
use Lab404\Impersonate\Events\TakeImpersonation;

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
        LabelCreated::class => [
            GenerateLabelFields::class,
        ],
        TakeImpersonation::class => [
            UserImpersonatedListener::class,
        ],
        LeaveImpersonation::class => [
            UserLeftImpersonationListener::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        User::observe(UserObserver::class);
    }
}
