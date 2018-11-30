# swoft-amqplib

[![Build Status](https://travis-ci.org/limingxinleo/swoft-amqplib.svg?branch=master)](https://travis-ci.org/limingxinleo/swoft-amqplib)

## 安装
~~~
composer require limingxinleo/swoft-amqplib
~~~

## 使用
Yii2框架
~~~php
<?php

use yii\base\StaticInstanceTrait;
use Swoftx\Amqplib\Connection;
use Swoftx\Amqplib\Message\Publisher;

class YiiConnection extends \Swoftx\Amqplib\Connection
{
    use StaticInstanceTrait;
}

class DemoMessage extends Publisher
{
    protected $exchange = 'demo';

    protected $queue = 'demo.queue';

    protected $routingKey = 'test';

    public function getConnection(): Connection
    {
        return YiiConnection::instance()->build();
    }
}

$msg = new DemoMessage();
$msg->setData(['id' => $id]);
$msg->publish();
~~~

Swoft 框架
~~~php
<?php

use Swoftx\Amqplib\Message\Publisher;
use Swoftx\Amqplib\SwoftConnection;
use Swoftx\Amqplib\Pool\RabbitMQPool;

class DemoMessage extends Publisher
{
    protected $exchange = 'demo';

    protected $queue = 'demo.queue';

    protected $routingKey = 'test';

    public function getConnection(): \Swoftx\Amqplib\Connection
    {
        $pool = \Swoft\App::getPool(RabbitMQPool::class);
        /** @var SwoftConnection $connection */
        $connection = $pool->getConnection();
        return $connection->getConnection();
    }
}

$msg = new DemoMessage();
$msg->setData(['id' => $id]);
$msg->publish();
~~~
