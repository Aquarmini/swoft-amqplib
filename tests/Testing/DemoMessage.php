<?php
/**
 * This file is part of Swoft.
 *
 * @link     https://swoft.org
 * @document https://doc.swoft.org
 * @contact  limingxin@swoft.org
 * @license  https://github.com/swoft-cloud/swoft/blob/master/LICENSE
 */

namespace SwoftTest\Testing;

use Swoftx\Amqplib\Connection;
use Swoftx\Amqplib\Message\Publisher;

class DemoMessage extends Publisher
{
    protected $exchange = 'demo';

    protected $queue = 'demo.queue';

    protected $routingKey = 'test';

    public function getConnection(): Connection
    {
        return \SwoftTest\Testing\Connection::getInstance()->build();
    }
}
