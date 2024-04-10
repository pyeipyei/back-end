<?php

namespace App\Listeners;

use App\Events\DashboardEvent;
use App\Models\Activity;
use Illuminate\Support\Facades\Auth;

class DashboardListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(DashboardEvent $event): void
    {
        Activity::create([
            'name' => Auth::user()->name,
            'action' => $event->dashboard[0],
            'description' => $event->dashboard[0] . ' ' . $event->dashboard[1] . ' in Home screen',
        ]);
    }
}
