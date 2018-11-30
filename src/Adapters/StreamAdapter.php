<?php
/**
 * This file is part of Swoft.
 *
 * @link     https://swoft.org
 * @document https://doc.swoft.org
 * @contact  limingxin@swoft.org
 * @license  https://github.com/swoft-cloud/swoft/blob/master/LICENSE
 */

namespace Swoftx\Amqplib\Adapters;

use PhpAmqpLib\Connection\AbstractConnection;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use Swoftx\Amqplib\Config;
use Swoftx\Amqplib\Params;

class StreamAdapter implements AdapterInterface
{
    public function initConnection(Config $config, Params $params): AbstractConnection
    {
        return new AMQPStreamConnection(
            $config->getHost(),
            $config->getPort(),
            $config->getUser(),
            $config->getPassword(),
            $config->getVhost(),
            $params->isInsist(),
            $params->getLoginMethod(),
            $params->getLoginResponse(),
            $params->getLocale(),
            $params->getConnectionTimeout(),
            $params->getReadWriteTimeout(),
            $params->getContext(),
            $params->isKeepalive(),
            $params->getHeartbeat()
        );
    }
}
