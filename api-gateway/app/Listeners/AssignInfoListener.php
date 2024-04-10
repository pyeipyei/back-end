<?php

namespace App\Listeners;

use App\Events\AssignInfoEvent;
use App\Models\Activity;
use Illuminate\Support\Facades\Auth;

class AssignInfoListener
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
    public function handle(AssignInfoEvent $event): void
    {
        Activity::create([
            'name' => Auth::user()->name,
            'action' => $event->assign[0],
            'description' => $event->assign[0] . ' ' . $event->assign[1] . ' in Assign Info screen',
        ]);
    }
}
