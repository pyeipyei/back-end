<?php

namespace App\Listeners;

use App\Events\RoleEvent;
use App\Models\Activity;
use Illuminate\Support\Facades\Auth;

class RoleListener
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
    public function handle(RoleEvent $event): void
    {
        Activity::create([
            'name' => Auth::user()->name,
            'action' => $event->role[0],
            'description' => $event->role[0] . ' ' . $event->role[1] . ' in Role screen',
        ]);
    }
}
