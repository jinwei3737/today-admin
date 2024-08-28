<?php

namespace App\Utils;

use App\Order\Models\Order;
use Exception;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class RabbitmqService
{
    private static function getConnect()
    {
        $config = [
            'host'     => env('RABBITMQ_HOST', '127.0.0.1'),
            'port'     => env('RABBITMQ_PORT', 5672),
            'user'     => env('RABBITMQ_USER', 'guest'),
            'password' => env('RABBITMQ_PASSWORD', 'guest'),
            'vhost'    => env('RABBITMQ_VHOST', '/'),
        ];
        return new AMQPStreamConnection($config['host'], $config['port'], $config['user'], $config['password'], $config['vhost']);
    }

    /**
     * 数据插入到mq队列中（生产者）
     * @param $queue .队列名称
     * @param $messageBody .消息体
     * @param string $exchange .交换机名称
     * @param string $routing_key .设置路由
     * @throws Exception
     */
    public static function push($queue, $exchange, $routing_key, $messageBody)
    {
        //获取连接
        $connection = self::getConnect();

        //构建通道（mq的数据存储与获取是通过通道进行数据传输的）
        $channel = $connection->channel();

        // 开启confirm模式，保证消息100%投递成功（补偿机制）
        // 投递消息后，RabbitMQ会异步返回是否投递成功（confirm模式不可以和事务模式同时存在）
        $channel->confirm_select();
        $channel->set_ack_handler(function (AMQPMessage $message) {
            // 投递成功
            $order = json_decode($message->body,true);
            Order::where('id', $order['id'])->update(['is_send' => 1]);
        });
        $channel->set_nack_handler(function (AMQPMessage $message) {
            // 投递失败
            throw new Exception('消息投递失败');
        });

        //声明交换机，将第四个参数设置为true，表示将交换机持久化
        $channel->exchange_declare($exchange, 'direct', false, true, false);

        //声明队列名称，将第三个参数设置为true，表示将队列持久化
        $channel->queue_declare($queue, false, true, false, false);

        //队列和交换器绑定/绑定队列和类型
        $channel->queue_bind($queue, $exchange, $routing_key);

        //消息类，设置delivery_mode为DELIVERY_MODE_PERSISTENT，表示将消息持久化
        $message = new AMQPMessage($messageBody, [
            'content_type'  => 'text/plain',
            'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT
        ]);

        //消息推送到路由名称为$exchange的队列当中
        $channel->basic_publish($message, $exchange, $routing_key);

        //监听写入
        $channel->wait_for_pending_acks();

        //关闭消息推送资源
        $channel->close();

        //关闭mq资源
        $connection->close();
    }

    /**
     * 消费者：取出消息进行消费，并返回
     * @param $queue
     * @param $callback
     * @return bool
     * @throws Exception
     */
    public static function pop($queue, $callback)
    {
        $connection = self::getConnect();

        //构建消息通道
        $channel = $connection->channel();

        //从队列中取出消息，并且消费
        $message = $channel->basic_get($queue);

        if (!$message) return false;

        //消息内容返回给回调函数处理
        $res = $callback($message->body);

        if (!$res) {
            //ack验证，如果消费失败了，从新获取一次数据再次消费
            print_r('消息消费失败：'. $message->body. PHP_EOL);
            $channel->basic_ack($message->getDeliveryTag());
        }
        print_r('消息消费成功：'. $message->body. PHP_EOL);

        $channel->close();
        $connection->close();

        return true;
    }
}
