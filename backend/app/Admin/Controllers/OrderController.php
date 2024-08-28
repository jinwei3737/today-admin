<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Order\Models\Order;

class OrderController extends Controller
{
    public function add()
    {
        $order = Order::create([
            'name'   => '测试订单1',
            'status' => 0,
        ]);

        $orderJob = new \App\Admin\Jobs\Order($order->toArray());
        $this->dispatch($orderJob);

        return apiReturn($order->toArray());
    }
}
