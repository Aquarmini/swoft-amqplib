<?php
/**
 * Created by PhpStorm.
 * User: limx
 * Date: 2018/11/30
 * Time: 5:43 PM
 */
namespace Swoftx\Amqplib\Pool;

use Swoft\App;
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