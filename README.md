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
use Swoft\Pool\ConnectionInterface;

class DemoMessage extends Publisher
{
    protected $exchange = 'demo';

    protected $queue = 'demo.queue';

    protected $routingKey = 'test';
    
    /** @var ConnectionInterface SwoftConnection */
    protected $swoftConnection;

    public function getConnection(): \Swoftx\Amqplib\Connection
    {
        $pool = \Swoft\App::getPool(RabbitMQPool::class);
        /** @var SwoftConnection $connection */
        $this->swoftConnection = $pool->getConnection();
        return $this->swoftConnection->getConnection();
    }
    
    public function publish()
    {
        parent::publish();
        // 释放资源 【很重要】
        $this->swoftConnection->release(true);
    }
}

$msg = new DemoMessage();
$msg->setData(['id' => $id]);
$msg->publish();
~~~

Swoft 对应配置默认值
~~~dotenv
RABBITMQ_MIN_ACTIVE=5
RABBITMQ_MAX_ACTIVE=10
RABBITMQ_MAX_WAIT=20
RABBITMQ_MAX_WAIT_TIME=3
RABBITMQ_MAX_IDLE_TIME=120
RABBITMQ_TIMEOUT=3
RABBITMQ_URI=127.0.0.1:5672
RABBITMQ_USER=guest
RABBITMQ_PASSWORD=guest
RABBITMQ_VHOST=/

RABBITMQ_PARAMS_INSIST=false
RABBITMQ_PARAMS_LOGIN_METHOD=AMQPLAIN
RABBITMQ_PARAMS_LOGIN_RESPONSE=null
RABBITMQ_PARAMS_LOCALE=en_US
RABBITMQ_PARAMS_CONNECTION_TIMEOUT=3
RABBITMQ_PARAMS_READ_WRITE_TIMEOUT=3
RABBITMQ_PARAMS_CONTEXT=null
RABBITMQ_PARAMS_KEEPALIVE=false
RABBITMQ_PARAMS_HEARTBEAT=0

~~~
