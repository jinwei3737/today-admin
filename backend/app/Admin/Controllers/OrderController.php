<?php

namespace App\Admin\Controllers;

use App\Admin\Events\Order as OrderEvent;
use App\Admin\Models\Order;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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

    public function finish(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:order,id',
        ]);

        $order = Order::find($request->id);

        $orderJob = new OrderQueue($order);
        $orderJob->handle();

        return apiReturn($order->toArray());
    }
}
