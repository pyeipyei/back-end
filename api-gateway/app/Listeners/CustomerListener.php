<?php

namespace App\Listeners;

use App\Events\CustomerEvent;
use App\Models\Activity;
use Illuminate\Support\Facades\Auth;

class CustomerListener
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
    public function handle(CustomerEvent $event): void
    {
        Activity::create([
            'name' => Auth::user()->name,
            'action' => $event->customer[0],
            'description' => $event->customer[0] . ' ' . $event->customer[1] . ' in Customer List screen',
        ]);
    }
}
