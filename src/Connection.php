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
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Connection\AMQPSwooleConnection;
use Swoole\Coroutine;

class Connection
{
    /** @var AbstractConnection */
    protected $connection;

    /** @var string */
    protected $adapter;

    /** @var Config */
    protected $config;

    public static function make()
    {
        return new static();
    }

    public function build()
    {
        if ($this->connection instanceof AbstractConnection && $this->connection->isConnected()) {
            return $this;
        }

        if (!isset($this->config)) {
            $this->config = new Config();
        }

        if (!isset($this->adapter)) {
            if (extension_loaded('swoole') && Coroutine::getuid() > 0) {
                $this->adapter = AMQPSwooleConnection::class;
            } else {
                $this->adapter = AMQPStreamConnection::class;
            }
        }

        $this->connection = new $this->adapter(
            $this->config->getHost(),
            $this->config->getPort(),
            $this->config->getUser(),
            $this->config->getPassword(),
            $this->config->getVhost()
        );

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
    public function getConfig(): Config
    {
        return $this->config;
    }

    /**
     * @param Config $config
     */
    public function setConfig(Config $config)
    {
        $this->config = $config;
    }
}
