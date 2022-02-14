<?php

namespace App\Listeners;

use App\Events\DeliveryEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class DeliveryListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  DeliveryEvent  $event
     * @return void
     */
    public function handle(DeliveryEvent $event)
    {
        //
    }
}
