<?php

namespace Swoftx\Amqplib\Message;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPSwooleConnection;
use Swoftx\Amqplib\Connection;
use Swoftx\Amqplib\Exceptions\MessageException;
use Swoftx\Amqplib\Packer\JsonPacker;
use Swoftx\Amqplib\Packer\PackerInterface;

abstract class Message
{
    protected $exchange;

    protected $queue;

    protected $routingKey = '';

    protected $type = 'topic';

    /** @var AMQPChannel */
    protected $channel;

    /** @var PackerInterface */
    protected $packer;

    /**
     * 拿到单例的Connection
     * @author limx
     * @return Connection
     */
    abstract public function getConnection(): Connection;

    public function __construct()
    {
        $this->check();

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

    protected function check()
    {
        if (!isset($this->exchange)) {
            throw new MessageException('exchange is required!');
        }

        if (!isset($this->type)) {
            throw new MessageException('type is required!');
        }

        if (!isset($this->queue)) {
            throw new MessageException('queue is required!');
        }

        if (!isset($this->routingKey)) {
            throw new MessageException('routingKey is required!');
        }
    }

    /**
     * @return PackerInterface
     */
    public function getPacker(): PackerInterface
    {
        return $this->packer ?? new JsonPacker();
    }

    /**
     * @param PackerInterface $packer
     */
    public function setPacker(PackerInterface $packer)
    {
        $this->packer = $packer;
        return $this;
    }
}