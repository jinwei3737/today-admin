<?php

namespace App\Order\Controller;

use App\Http\Controllers\Controller;
use App\Order\Models\Order;
use App\Utils\ElasticsearchService;

class OrderController extends Controller
{
    public $elasticsearch;

    public function __construct(ElasticsearchService $elasticsearch)
    {
        $this->elasticsearch = $elasticsearch;
    }

    public function add()
    {
        $data = [];


        for ($i=0;$i<10;$i++){
            $order = Order::create([
                'name'   => '测试订单1',
                'no'     => 'DD' . date('YmdHis') . mt_rand(1000, 9999),
                'status' => 0,
            ]);

            $data[] = $this->elasticsearch->index('my_index', $order->id, $order);
        }

        return apiReturn($data);
    }
}
