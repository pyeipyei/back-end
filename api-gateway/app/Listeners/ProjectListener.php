<?php

namespace App\Listeners;

use App\Events\ProjectEvent;
use App\Models\Activity;
use Illuminate\Support\Facades\Auth;

class ProjectListener
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
    public function handle(ProjectEvent $event): void
    {
        Activity::create([
            'name' => Auth::user()->name,
            'action' => $event->project[0],
            'description' => $event->project[0] . ' ' . $event->project[1] . ' in Project screen',
        ]);
    }
}
