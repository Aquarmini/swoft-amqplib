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

use Xin\Traits\Common\InstanceTrait;

class Connection extends \Swoftx\Amqplib\Connection
{
    use InstanceTrait;
}
