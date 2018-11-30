<?php
/**
 * This file is part of Swoft.
 *
 * @link     https://swoft.org
 * @document https://doc.swoft.org
 * @contact  limingxin@swoft.org
 * @license  https://github.com/swoft-cloud/swoft/blob/master/LICENSE
 */
namespace Swoftx\Amqplib\Pool;

use Swoft\Bean\Annotation\Inject;
use Swoft\Bean\Annotation\Pool;
use Swoft\Pool\ConnectionInterface;
use Swoft\Pool\ConnectionPool;
use Swoftx\Amqplib\Pool\Config\RabbitMQPoolConfig;
use Swoftx\Amqplib\SwoftConnection;

/**
 * RabbitMQPool
 *
 * @Pool()
 */
class RabbitMQPool extends ConnectionPool
{
    /**
     * Config
     *
     * @Inject()
     * @var RabbitMQPoolConfig
     */
    protected $poolConfig;

    /**
     * Create connection
     *
     * @return ConnectionInterface
     */
    public function createConnection(): ConnectionInterface
    {
        $connection = new SwoftConnection($this);
        return $connection;
    }
}
