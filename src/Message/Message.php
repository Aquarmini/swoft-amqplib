<?php


namespace Swoftx\Amqplib\Message;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPSwooleConnection;
use PhpAmqpLib\Message\AMQPMessage;
use Swoftx\Amqplib\Connection;

abstract class Message implements MessageInterface
{
    protected $exchange;

    protected $queue;

    protected $routingKey;

    protected $type = 'topic';

    /** @var AMQPChannel */
    protected $channel;

    protected $properties = [
        'content_type' => 'text/plain',
        'delivery_mode' => 2
    ];

    /**
     * 拿到单例的Connection
     * @author limx
     * @return Connection
     */
    abstract public function getConnection(): Connection;

    public function declare()
    {
        if (!isset($this->channel)) {
            /** @var AMQPSwooleConnection $conn */
            $conn = $this->getConnection()->getConnection();
            $this->channel = $conn->channel();
        }

        $this->channel->exchange_declare($this->exchange, $this->type, false, true, false);

        $header = [
            'x-ha-policy' => ['S', 'all']
        ];
        $this->channel->queue_declare($this->queue, false, true, false, false, false, $header);
        $this->channel->queue_bind($this->queue, $this->exchange, $this->routingKey);
    }

    public function publish()
    {
        $this->declare();

        $body = $this->message();
        $msg = new AMQPMessage($body, $this->properties);
        $this->channel->basic_publish($msg, $this->exchange, $this->routingKey);
    }
}