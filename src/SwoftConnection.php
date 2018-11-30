<?php
/**
 * Created by PhpStorm.
 * User: limx
 * Date: 2018/11/30
 * Time: 5:47 PM
 */

namespace Swoftx\Amqplib;


use Swoft\Helper\PhpHelper;
use Swoft\Pool\AbstractConnection;
use PhpAmqpLib\Connection\AbstractConnection as PhpAmqpLibConnection;
use Swoftx\Amqplib\Pool\Config\RabbitMQPoolConfig;
use Swoftx\Amqplib\Pool\RabbitMQPool;
use Swoftx\Amqplib\Connection;

class SwoftConnection extends AbstractConnection
{
    /**
     * @var Connection
     */
    protected $connection;

    public function createConnection()
    {
        /** @var RabbitMQPool $pool */
        $pool = $this->getPool();
        /** @var RabbitMQPoolConfig $config */
        $config = $pool->getPoolConfig();

        $conn = new Connection();
        $conn->setConfig($config);

        $this->connection = $conn->build();
    }

    public function reconnect()
    {
        if (isset($this->connection)) {
            $this->connection->close();
        }
        $this->createConnection();
        return $this;
    }

    public function check(): bool
    {
        $lastTime = $this->getLastTime();
        $idleTime = $this->getPool()->getPoolConfig()->getMaxIdleTime();
        if ($lastTime + $idleTime < time()) {
            return false;
        }

        return $this->connection->check();
    }

    /**
     * @param string $method
     * @param array  $arguments
     *
     * @return mixed
     */
    public function __call($method, $arguments)
    {
        return PhpHelper::call([$this->connection, $method], $arguments);
    }
}