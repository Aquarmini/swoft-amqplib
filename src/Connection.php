<?php

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

    /**
     * @return mixed
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * @param mixed $connection
     */
    public function setConnection($connection)
    {
        $this->connection = $connection;
    }

    /**
     * @return mixed
     */
    public function getAdapter()
    {
        return $this->adapter;
    }

    /**
     * @param mixed $adapter
     */
    public function setAdapter($adapter)
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