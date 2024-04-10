<?php

namespace App\Listeners;

use App\Events\EngineerEvent;
use App\Models\Activity;
use Illuminate\Support\Facades\Auth;


class EngineerListener
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
    public function handle(EngineerEvent $event): void
    {
        Activity::create([
            'name' => Auth::user()->name,
            'action' => $event->engineer[0],
            'description' => $event->engineer[0] . ' ' . $event->engineer[1] . ' in Engineer List screen',
        ]);
    }
}
