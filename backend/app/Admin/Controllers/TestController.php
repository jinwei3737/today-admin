<?php

namespace App\Admin\Controllers;

use App\Admin\Models\Order;
use App\Http\Controllers\Controller;
use App\Jobs\TestQueue;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function createdOrder()
    {
        $order = Order::create([
            'name'   => '测试订单1',
            'status' => 0,
        ]);

        $orderJob = new TestQueue($order);
        $this->dispatch($orderJob);

        return apiReturn($order);
    }

    public function finishOrder(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:order,id',
        ]);

        dd($request->id);
    }
}
