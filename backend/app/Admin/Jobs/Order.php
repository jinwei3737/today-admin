<?php

namespace App\Admin\Jobs;

use App\Utils\RabbitmqService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class Order implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $orderKey;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->orderKey = "order::info::{$data['id']}";

        //消息生产
        RabbitmqService::push('order', 'exc_order', 'pus_order', json_encode($data));
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        RabbitmqService::pop('order', function ($data) {
            $order = json_decode($data, true);
//            $res   = \App\Admin\Models\Order::where('id', $order['id'])->update([
//                'status' => 1
//            ]);
            $res = \App\Admin\Models\Order::where('id', $order['id'])->increment('status', 1);

//            $key = $this->orderKey . ':' . date('Y-m-d H:i:s');
//            $product = app('redis')->set($key, $input);

            if ($res) {
                //消息消费成功
                return true;
            }
            return false;
        });
    }
}
