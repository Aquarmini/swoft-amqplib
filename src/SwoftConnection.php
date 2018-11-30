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
        $params = bean(Params::class);

        $conn = new Connection();
        $conn->setConfig($config);
        $conn->setParams($params);

        $this->connection = $conn->build();
    }

    public function getConnection()
    {
        return $this->connection;
    }

    public function reconnect()
    {
        if (isset($this->connection) && $this->connection instanceof Connection) {
            try {
                $this->connection->close();
            } catch (\Throwable $ex) {
                // TODO: 抛出错误日志
            }
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
