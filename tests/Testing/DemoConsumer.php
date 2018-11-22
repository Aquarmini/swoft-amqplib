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
use Swoftx\Amqplib\Message\Consumer;

class DemoConsumer extends Consumer
{
    protected $exchange = 'demo';

    protected $queue = 'demo.queue';

    protected $routingKey = 'test';

    public function handle($data): bool
    {
        $id = $data['id'];

        file_put_contents(TESTS_PATH . '/' . $id, $id);

        return true;
    }

    public function getConnection(): Connection
    {
        return \SwoftTest\Testing\Connection::getInstance()->build();
    }
}
