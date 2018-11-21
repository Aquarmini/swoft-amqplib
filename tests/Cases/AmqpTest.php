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

class AmqpTest extends AbstractTestCase
{
    public function testSendMessage()
    {
        $msg = new DemoMessage();
        $msg->setData(['id' => 1]);
        $msg->publish();
    }
}
