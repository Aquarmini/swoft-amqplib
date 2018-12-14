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
use PhpAmqpLib\Exception\AMQPRuntimeException;
use Swoftx\Amqplib\CacheManager\CacheInterface;
use Swoftx\Amqplib\CacheManager\Memory;
use Swoftx\Amqplib\Connection;
use Swoftx\Amqplib\Connections\AMQPSwooleConnection;
use Swoftx\Amqplib\Exceptions\MessageException;
use Swoftx\Amqplib\Packer\JsonPacker;
use Swoftx\Amqplib\Packer\PackerInterface;

abstract class Message
{
    protected $exchange;

    protected $type = 'topic';

    protected $routingKey = '';

    /** @var AMQPSwooleConnection */
    protected $connection;

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
            /** @var Connection $conn */
            $conn = $this->getConnection();
            $this->connection = $conn->getConnection();
            try {
                $this->channel = $this->connection->channel();
            } catch (AMQPRuntimeException $ex) {
                // 获取channel时失败，重连Connection并获取channel
                $this->connection->reconnect();
                $this->channel = $this->connection->channel();
            }
        }

        $this->declare();
    }

    /**
     * 拿到单例的Connection
     * @author limx
     * @return Connection
     */
    abstract protected function getConnection(): Connection;

    abstract protected function declare();

    public function close()
    {
        $this->connection->close();
    }

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
