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

abstract class Consumer extends Message implements ConsumerInterface
{
    protected $status = true;

    abstract public function handle($data): bool;

    public function callback(AMQPMessage $msg)
    {
        $packer = $this->getPacker();
        $body = $msg->getBody();
        $data = $packer->unpack($body);

        try {
            if ($this->handle($data)) {
                $this->ack($msg);
            } else {
                $this->reject($msg);
            }
        } catch (\Throwable $ex) {
            $this->reject($msg);
        }
    }

    public function consume()
    {
        pcntl_async_signals(true);

        pcntl_signal(SIGQUIT, [$this, 'signalHandler']);
        pcntl_signal(SIGTERM, [$this, 'signalHandler']);
        pcntl_signal(SIGTSTP, [$this, 'signalHandler']);

        $this->channel->basic_consume(
            $this->queue,
            $this->routingKey,
            false,
            false,
            false,
            false,
            [$this, 'callback']
        );

        while ($this->status && count($this->channel->callbacks) > 0) {
            $this->channel->wait();
        }
    }

    /**
     * 消费成功应答
     */
    public function ack(AMQPMessage $msg)
    {
        $this->channel->basic_ack($msg->delivery_info['delivery_tag']);
    }

    /**
     * 当前消费者拒绝处理
     */
    public function reject(AMQPMessage $msg)
    {
        $this->channel->basic_reject($msg->delivery_info['delivery_tag'], true);
    }

    public function signalHandler()
    {
        $this->status = false;
    }
}
