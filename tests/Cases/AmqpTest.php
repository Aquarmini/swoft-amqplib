<?php
/**
 * This file is part of Swoft.
 *
 * @link     https://swoft.org
 * @document https://doc.swoft.org
 * @contact  limingxin@swoft.org
 * @license  https://github.com/swoft-cloud/swoft/blob/master/LICENSE
 */
namespace SwoftTest\Cases;

use SwoftTest\Testing\DemoMessage;
use Swoftx\Amqplib\CacheManager\Memory;

class AmqpTest extends AbstractTestCase
{
    public function testSendMessage()
    {
        $id = uniqid();
        $msg = new DemoMessage();
        $msg->setData(['id' => $id]);
        $msg->publish();

        sleep(1);
        $res = file_get_contents(TESTS_PATH . '/' . $id);
        $this->assertEquals($id, $res);
    }

    public function testCacheManager()
    {
        $cache = new Memory();
        $cache->set('xxxxxx', 1);

        $this->assertTrue($cache->has('xxxxxx'));
        $this->assertEquals(1, $cache->get('xxxxxx'));
    }
}
