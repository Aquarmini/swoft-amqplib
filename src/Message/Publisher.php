<?php
/**
 * This file is part of Swoft.
 *
 * @link     https://swoft.org
 * @document https://doc.swoft.org
 * @contact  limingxin@swoft.org
 * @license  https://github.com/swoft-cloud/swoft/blob/master/LICENSE
 */

namespace Swoftx\Amqplib\Message;

use PhpAmqpLib\Message\AMQPMessage;
use Swoftx\Amqplib\Constants;
use Swoftx\Amqplib\Exceptions\MessageException;

abstract class Publisher extends Message implements PublisherInterface
{
    protected $data;

    protected $properties = [
        'content_type' => 'text/plain',
        'delivery_mode' => Constants::DELIVERY_MODE_PERSISTENT
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
        return $this;
    }
}
