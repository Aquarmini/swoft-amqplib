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

use Swoft\Helper\PhpHelper;
use Swoft\Pool\AbstractConnection;
use Swoftx\Amqplib\Pool\Config\RabbitMQPoolConfig;
use Swoftx\Amqplib\Pool\RabbitMQPool;

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
