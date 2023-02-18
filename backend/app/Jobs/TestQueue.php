<?php

namespace App\Jobs;

use App\Admin\Services\RabbitmqService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class TestQueue implements ShouldQueue
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
        $this->orderKey = "order::info::{$data->id}";

        //服务生产者
        RabbitmqService::push('order', 'exc_order', 'pus_order', $data);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        RabbitmqService::pop('order', function ($message) {
            print_r('消费者消费消息' . PHP_EOL);

            print_r(PHP_EOL);

            $key = $this->orderKey . ':' . date('Y-m-d H:i:s');

            $input = serialize(json_decode($message, true));

            $order = app('redis')->set($key, $input);

            if ($order) {
                print_r('消息消费成功');
                return true;
            } else {
                print_r('消息消费失败');
                return false;
            }
        });
    }

    /**
     * 异常扑获
     * @param \Exception $exception
     */
    public function failed(\Exception $exception)
    {
        print_r($exception->getMessage());
    }
}
