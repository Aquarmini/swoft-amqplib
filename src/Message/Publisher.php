<?php


namespace Swoftx\Amqplib\Message;

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPSwooleConnection;
use PhpAmqpLib\Message\AMQPMessage;
use Swoftx\Amqplib\Connection;
use Swoftx\Amqplib\Exceptions\MessageException;

abstract class Publisher extends Message implements PublisherInterface
{
    protected $data;

    protected $properties = [
        'content_type' => 'text/plain',
        'delivery_mode' => 2
    ];

    public function publish()
    {
        $data = $this->getData();
        if (!isset($data)) {
            throw new MessageException('data is required!');
        }

        $packer = $this->getPacker();

        $body = $packer->pack($data);
        $msg = new AMQPMessage($body, $this->properties);
        $this->channel->basic_publish($msg, $this->exchange, $this->routingKey);

        $this->channel->close();
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }
}