<?php

namespace App\Listeners;

use App\Events\AuthEvent;
use App\Models\Activity;
use Illuminate\Support\Facades\Auth;


class AuthListener
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
    public function handle(AuthEvent $event): void
    {
        Activity::create([
            'name' => $event->auth[2],
            'action' => $event->auth[0],
            'description' => $event->auth[0] . ' ' . $event->auth[1],
        ]);
    }
}
