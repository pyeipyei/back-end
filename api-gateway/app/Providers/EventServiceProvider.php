<?php

namespace App\Providers;

use App\Events\AssignInfoEvent;
use App\Events\AuthEvent;
use App\Events\CostEvent;
use App\Events\CustomerEvent;
use App\Events\DashboardEvent;
use App\Events\DepartmentEvent;
use App\Events\EngineerAssignEvent;
use App\Events\EngineerEvent;
use App\Events\ProjectEvent;
use App\Events\RoleEvent;
use App\Listeners\AssignInfoListener;
use App\Listeners\AuthListener;
use App\Listeners\CostListener;
use App\Listeners\CustomerListener;
use App\Listeners\DashboardListener;
use App\Listeners\DepartmentListener;
use App\Listeners\EngineerAssignListener;
use App\Listeners\EngineerListener;
use App\Listeners\ProjectListener;
use App\Listeners\RoleListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        RoleEvent::class => [
            RoleListener::class,
        ],
        DepartmentEvent::class => [
            DepartmentListener::class,
        ],
        ProjectEvent::class => [
            ProjectListener::class,
        ],
        AssignInfoEvent::class => [
            AssignInfoListener::class,
        ],
        EngineerAssignEvent::class => [
            EngineerAssignListener::class,
        ],
        DashboardEvent::class => [
            DashboardListener::class,
        ],
        CustomerEvent::class => [
            CustomerListener::class,
        ],
        EngineerEvent::class => [
            EngineerListener::class,
        ],
        CostEvent::class => [
            CostListener::class,
        ],
        AuthEvent::class => [
            AuthListener::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
