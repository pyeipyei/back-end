<?php

namespace App\Listeners;

use App\Events\CostEvent;
use App\Models\Activity;
use Illuminate\Support\Facades\Auth;


class CostListener
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
    public function handle(CostEvent $event): void
    {
        Activity::create([
            'name' => Auth::user()->name,
            'action' => $event->cost[0],
            'description' => $event->cost[0] . ' ' . $event->cost[1],
        ]);
    }
}
