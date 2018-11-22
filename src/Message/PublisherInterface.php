<?php
/**
 * This file is part of Swoft.
 *
 * @link     https://swoft.org
 * @document https://doc.swoft.org
 * @contact  limingxin@swoft.org
 * @license  https://github.com/swoft-cloud/swoft/blob/master/LICENSE
 */

namespace Swoftx\Amqplib\Message;

interface PublisherInterface
{
    /**
     * 推送消息
     * @author limx
     * @return mixed
     */
    public function publish();
}
