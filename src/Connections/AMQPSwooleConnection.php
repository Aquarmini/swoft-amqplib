<?php
/**
 * This file is part of Swoft.
 *
 * @link     https://swoft.org
 * @document https://doc.swoft.org
 * @contact  limingxin@swoft.org
 * @license  https://github.com/swoft-cloud/swoft/blob/master/LICENSE
 */
namespace Swoftx\Amqplib\Connections;

use PhpAmqpLib\Connection\AbstractConnection;
use PhpAmqpLib\Wire\IO\SwooleIO;

class AMQPSwooleConnection extends AbstractConnection
{
    /**
     * @param string $host
     * @param int    $port
     * @param string $user
     * @param string $password
     * @param string $vhost
     * @param bool   $insist
     * @param string $login_method
     * @param null   $login_response
     * @param string $locale
     * @param float  $read_timeout
     * @param bool   $keepalive
     * @param int    $write_timeout
     * @param int    $heartbeat
     */
    public function __construct(
        $host,
        $port,
        $user,
        $password,
        $vhost = '/',
        $insist = false,
        $login_method = 'AMQPLAIN',
        $login_response = null,
        $locale = 'en_US',
        $connection_timeout = 3.0,
        $read_write_timeout = 3.0,
        $context = null,
        $keepalive = false,
        $heartbeat = 0
    ) {
        $io = new SwooleIO($host, $port, $connection_timeout, $read_write_timeout, $keepalive, $heartbeat);

        parent::__construct(
            $user,
            $password,
            $vhost,
            $insist,
            $login_method,
            $login_response,
            $locale,
            $io,
            $heartbeat
        );
    }
}
