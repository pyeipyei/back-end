<?php

namespace App\Listeners;

use App\Events\EngineerAssignEvent;
use App\Models\Activity;
use Illuminate\Support\Facades\Auth;

class EngineerAssignListener
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
    public function handle(EngineerAssignEvent $event): void
    {
        Activity::create([
            'name' => Auth::user()->name,
            'action' => $event->data[3],
            'description' => $event->data[3] . ' Assign Engineer(' . $event->data[2] . ') Date(' . $event->data[0] . ' ~ ' . $event->data[1] . ') in Engineer Assign screen',
        ]);
    }
}
