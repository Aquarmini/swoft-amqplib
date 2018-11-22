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

use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPSwooleConnection;
use Swoftx\Amqplib\CacheManager\CacheInterface;
use Swoftx\Amqplib\CacheManager\Memory;
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

    /** @var CacheInterface */
    protected $cacheManager;

    public static function make()
    {
        $args = func_get_args();
        return new static(...$args);
    }

    public function __construct()
    {
        $this->check();

        if (!isset($this->channel)) {
            /** @var AMQPSwooleConnection $conn */
            $conn = $this->getConnection()->getConnection();
            $this->channel = $conn->channel();
        }

        if (!$this->isDeclare()) {
            $this->channel->exchange_declare($this->exchange, $this->type, false, true, false);

            $header = [
                'x-ha-policy' => ['S', 'all']
            ];
            $this->channel->queue_declare($this->queue, false, true, false, false, false, $header);
            $this->channel->queue_bind($this->queue, $this->exchange, $this->routingKey);

            $key = sprintf("%s:%s:%s:%s", $this->exchange, $this->type, $this->queue, $this->routingKey);
            $this->getCacheManager()->set($key, 1);
        }
    }

    /**
     * 拿到单例的Connection
     * @author limx
     * @return Connection
     */
    abstract public function getConnection(): Connection;

    /**
     * 检验消息队列配置是否合法
     * @author limx
     * @throws MessageException
     */
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
     * 是否已经声明过exchange、queue并进行绑定
     * @author limx
     * @return bool
     */
    protected function isDeclare()
    {
        $key = sprintf("%s:%s:%s:%s", $this->exchange, $this->type, $this->queue, $this->routingKey);
        if ($this->getCacheManager()->has($key)) {
            return true;
        }
        return false;
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

    /**
     * @return CacheInterface
     */
    public function getCacheManager(): CacheInterface
    {
        return $this->cacheManager ?? new Memory();
    }

    /**
     * @param CacheInterface $cacheManager
     */
    public function setCacheManager(CacheInterface $cacheManager)
    {
        $this->cacheManager = $cacheManager;
        return $this;
    }
}
