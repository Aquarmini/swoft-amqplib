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

use Swoft\Bean\Annotation\Bean;
use Swoft\Bean\Annotation\Inject;
use Swoftx\Amqplib\Connection as AmqpConnection;

/**
 * @Bean
 */
class SwoftConnection extends AmqpConnection
{
    /**
     * @Inject
     * @var Config
     */
    protected $config;
}

use Swoftx\Amqplib\ConfigInterface;
use Swoft\Bean\Annotation\Value;

/**
 * @Bean
 */
class Config implements ConfigInterface
{
    /**
     * @Value(env="${AMQP_HOST}")
     * @var string
     */
    protected $host = '127.0.0.1';

    /**
     * @Value(env="${AMQP_PORT}")
     * @var integer
     */
    protected $port = 5672;

    /**
     * @Value(env="${AMQP_USER}")
     * @var string
     */
    protected $user = 'guest';

    /**
     * @Value(env="${AMQP_PASSWORD}")
     * @var string
     */
    protected $password = 'guest';

    /**
     * @Value(env="${AMQP_VHOST}")
     * @var string
     */
    protected $vhost = '/';

    public function getHost(): string
    {
        return $this->host;
    }

    public function getPort(): int
    {
        return $this->port;
    }

    public function getUser(): string
    {
        return $this->user;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getVhost(): string
    {
        return $this->vhost;
    }
}

class DemoMessage extends Publisher
{
    protected $exchange = 'demo';

    protected $queue = 'demo.queue';

    protected $routingKey = 'test';

    public function getConnection(): Connection
    {
        return bean(SwoftConnection::class)->build();
    }
}

$msg = new DemoMessage();
$msg->setData(['id' => $id]);
$msg->publish();
~~~
