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

class Params
{
    protected $insist = false;

    protected $loginMethod = 'AMQPLAIN';

    protected $loginResponse = null;

    protected $locale = 'en_US';

    protected $connectionTimeout = 3.0;

    protected $readWriteTimeout = 3.0;

    protected $context = null;

    protected $keepalive = false;

    protected $heartbeat = 1;

    /**
     * @return bool
     */
    public function isInsist(): bool
    {
        return $this->insist;
    }

    /**
     * @param bool $insist
     */
    public function setInsist(bool $insist)
    {
        $this->insist = $insist;
    }

    /**
     * @return string
     */
    public function getLoginMethod(): string
    {
        return $this->loginMethod;
    }

    /**
     * @param string $loginMethod
     */
    public function setLoginMethod(string $loginMethod)
    {
        $this->loginMethod = $loginMethod;
    }

    /**
     * @return null
     */
    public function getLoginResponse()
    {
        return $this->loginResponse;
    }

    /**
     * @param null $loginResponse
     */
    public function setLoginResponse($loginResponse)
    {
        $this->loginResponse = $loginResponse;
    }

    /**
     * @return string
     */
    public function getLocale(): string
    {
        return $this->locale;
    }

    /**
     * @param string $locale
     */
    public function setLocale(string $locale)
    {
        $this->locale = $locale;
    }

    /**
     * @return float
     */
    public function getConnectionTimeout(): float
    {
        return $this->connectionTimeout;
    }

    /**
     * @param float $connectionTimeout
     */
    public function setConnectionTimeout(float $connectionTimeout)
    {
        $this->connectionTimeout = $connectionTimeout;
    }

    /**
     * @return float
     */
    public function getReadWriteTimeout(): float
    {
        return $this->readWriteTimeout;
    }

    /**
     * @param float $readWriteTimeout
     */
    public function setReadWriteTimeout(float $readWriteTimeout)
    {
        $this->readWriteTimeout = $readWriteTimeout;
    }

    /**
     * @return null
     */
    public function getContext()
    {
        return $this->context;
    }

    /**
     * @param null $context
     */
    public function setContext($context)
    {
        $this->context = $context;
    }

    /**
     * @return bool
     */
    public function isKeepalive(): bool
    {
        return $this->keepalive;
    }

    /**
     * @param bool $keepalive
     */
    public function setKeepalive(bool $keepalive)
    {
        $this->keepalive = $keepalive;
    }

    /**
     * @return int
     */
    public function getHeartbeat(): int
    {
        return $this->heartbeat;
    }

    /**
     * @param int $heartbeat
     */
    public function setHeartbeat(int $heartbeat)
    {
        $this->heartbeat = $heartbeat;
    }
}
