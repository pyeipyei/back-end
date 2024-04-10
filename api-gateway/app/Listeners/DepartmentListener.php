<?php

namespace App\Listeners;

use App\Events\DepartmentEvent;
use App\Models\Activity;
use Illuminate\Support\Facades\Auth;

class DepartmentListener
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
    public function handle(DepartmentEvent $event): void
    {
        Activity::create([
            'name' => Auth::user()->name,
            'action' => $event->department[0],
            'description' => $event->department[0] . ' ' . $event->department[1] . ' in Department screen',
        ]);
    }
}
