<?php


namespace SwoftTest\Testing;


use Swoftx\Amqplib\Connection;
use Swoftx\Amqplib\Message\Publisher;

class DemoMessage extends Publisher
{
    protected $exchange = 'demo';

    protected $queue = 'demo.queue';

    protected $routingKey = 'test';

    public function message()
    {
        return 'hello world!';
    }

    public function getConnection(): Connection
    {
        return (new \Swoftx\Amqplib\Connection())->build();
    }
}