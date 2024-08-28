<?php

namespace App\Order\Listeners;

use App\Order\Events\Order as OrderEvent;

class OrderCreate
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
     * @param  \App\Order\Events\Order  $event
     * @return void
     */
    public function handle(OrderEvent $event)
    {
        //$event->order
    }
}
