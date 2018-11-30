<?php
/**
 * This file is part of Swoft.
 *
 * @link     https://swoft.org
 * @document https://doc.swoft.org
 * @contact  limingxin@swoft.org
 * @license  https://github.com/swoft-cloud/swoft/blob/master/LICENSE
 */
namespace Swoftx\Amqplib;

use PhpAmqpLib\Connection\AbstractConnection;
use Swoftx\Amqplib\Adapters\AdapterInterface;
use Swoftx\Amqplib\Adapters\StreamAdapter;
use Swoftx\Amqplib\Adapters\SwooleAdapter;
use Swoole\Coroutine;

class Connection
{
    /** @var AbstractConnection */
    protected $connection;

    /** @var string */
    protected $adapter;

    /** @var ConfigInterface */
    protected $config;

    /** @var Params */
    protected $params;

    /** @var int */
    protected $lastSendTime = null;

    /** @var int */
    protected $channelId = 0;

    public static function make()
    {
        return new static();
    }

    public function build()
    {
        if ($this->connection instanceof AbstractConnection && $this->connection->isConnected() && !$this->isHeartbeatTimeout()) {
            return $this;
        }

        if (!isset($this->config) || !$this->config instanceof ConfigInterface) {
            $this->config = new Config();
        }

        if (!isset($this->params) || !$this->params instanceof Params) {
            $this->params = new Params();
        }

        if (!isset($this->adapter)) {
            if (extension_loaded('swoole') && Coroutine::getuid() > 0) {
                $this->adapter = SwooleAdapter::class;
            } else {
                $this->adapter = StreamAdapter::class;
            }
        }

        /** @var AdapterInterface $adapter */
        $adapter = new $this->adapter();
        $this->connection = $adapter->initConnection($this->config, $this->params);
        $this->channelId = 0;

        return $this;
    }

    public function check(): bool
    {
        return $this->connection->isConnected();
    }

    public function reconnect()
    {
        return $this->connection->reconnect();
    }

    public function getChannelId()
    {
        return ++$this->channelId;
    }

    /**
     * 检查心跳是否超时
     * @return bool
     */
    public function isHeartbeatTimeout(): bool
    {
        if ($this->params->getHeartbeat() === 0) {
            return false;
        }

        $lastSendTime = $this->lastSendTime;
        $currentTime = microtime(true);
        $this->lastSendTime = $currentTime;

        if (isset($this->lastSendTime) && $this->lastSendTime > 0) {
            if ($currentTime - $lastSendTime > $this->params->getHeartbeat()) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return AbstractConnection
     */
    public function getConnection(): AbstractConnection
    {
        return $this->connection;
    }

    /**
     * @param AbstractConnection $connection
     */
    public function setConnection(AbstractConnection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @return string
     */
    public function getAdapter(): string
    {
        return $this->adapter;
    }

    /**
     * @param string $adapter
     */
    public function setAdapter(string $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * @return Config
     */
    public function getConfig(): ConfigInterface
    {
        return $this->config;
    }

    /**
     * @param ConfigInterface $config
     */
    public function setConfig(ConfigInterface $config)
    {
        $this->config = $config;
    }

    /**
     * @return Params
     */
    public function getParams(): Params
    {
        return $this->params;
    }

    /**
     * @param Params $params
     */
    public function setParams(Params $params)
    {
        $this->params = $params;
    }
}
