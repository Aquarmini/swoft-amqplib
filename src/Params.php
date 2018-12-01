<?php
/**
 * This file is part of Swoft.
 *
 * @link     https://swoft.org
 * @document https://doc.swoft.org
 * @contact  limingxin@swoft.org
 * @license  https://github.com/swoft-cloud/swoft/blob/master/LICENSE
 */

namespace Swoftx\Amqplib;

use Swoft\Bean\Annotation\Bean;
use Swoft\Bean\Annotation\Value;

/**
 * @Bean
 */
class Params implements ParamsInterface
{
    /**
     * @Value(name="${config.rabbitMQ.params.insist}", env="${RABBITMQ_PARAMS_INSIST}")
     * @var bool
     */
    protected $insist = false;

    /**
     * @Value(name="${config.rabbitMQ.params.loginMethod}", env="${RABBITMQ_PARAMS_LOGIN_METHOD}")
     * @var string
     */
    protected $loginMethod = 'AMQPLAIN';

    /**
     * @Value(name="${config.rabbitMQ.params.loginResponse}", env="${RABBITMQ_PARAMS_LOGIN_RESPONSE}")
     */
    protected $loginResponse = null;

    /**
     * @Value(name="${config.rabbitMQ.params.locale}", env="${RABBITMQ_PARAMS_LOCALE}")
     * @var string
     */
    protected $locale = 'en_US';

    /**
     * @Value(name="${config.rabbitMQ.params.connectionTimeout}", env="${RABBITMQ_PARAMS_CONNECTION_TIMEOUT}")
     * @var float
     */
    protected $connectionTimeout = 3.0;

    /**
     * @Value(name="${config.rabbitMQ.params.readWriteTimeout}", env="${RABBITMQ_PARAMS_READ_WRITE_TIMEOUT}")
     * @var float
     */
    protected $readWriteTimeout = 3.0;

    /**
     * @Value(name="${config.rabbitMQ.params.context}", env="${RABBITMQ_PARAMS_CONTEXT}")
     */
    protected $context = null;

    /**
     * @Value(name="${config.rabbitMQ.params.keepalive}", env="${RABBITMQ_PARAMS_KEEPALIVE}")
     * @var bool
     */
    protected $keepalive = false;

    /**
     * @Value(name="${config.rabbitMQ.params.heartbeat}", env="${RABBITMQ_PARAMS_HEARTBEAT}")
     */
    protected $heartbeat = 0;

    /**
     * @return bool
     */
    public function isInsist(): bool
    {
        return $this->insist;
    }

    /**
     * @return string
     */
    public function getLoginMethod(): string
    {
        return $this->loginMethod;
    }

    /**
     * @return null
     */
    public function getLoginResponse()
    {
        return $this->loginResponse;
    }

    /**
     * @return string
     */
    public function getLocale(): string
    {
        return $this->locale;
    }

    /**
     * @return float
     */
    public function getConnectionTimeout(): float
    {
        return $this->connectionTimeout;
    }

    /**
     * @return float
     */
    public function getReadWriteTimeout(): float
    {
        return $this->readWriteTimeout;
    }

    /**
     * @return null
     */
    public function getContext()
    {
        return $this->context;
    }

    /**
     * @return bool
     */
    public function isKeepalive(): bool
    {
        return $this->keepalive;
    }

    /**
     * @return int
     */
    public function getHeartbeat(): int
    {
        return $this->heartbeat;
    }
}
