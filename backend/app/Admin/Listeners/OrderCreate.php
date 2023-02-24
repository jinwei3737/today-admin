<?php

namespace App\Admin\Listeners;

use App\Admin\Events\Order as OrderEvent;
use App\Utils\RabbitmqService;

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
     * @param  \App\Admin\Events\Order  $event
     * @return void
     */
    public function handle(OrderEvent $event)
    {
        RabbitmqService::push('order', 'exc_order', 'pus_order', $event->order->jsonSerialize());
    }
}
