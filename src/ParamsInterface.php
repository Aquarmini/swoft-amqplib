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

interface ParamsInterface
{
    /**
     * @return bool
     */
    public function isInsist(): bool;

    /**
     * @return string
     */
    public function getLoginMethod(): string;

    /**
     * @return null
     */
    public function getLoginResponse();

    /**
     * @return string
     */
    public function getLocale(): string;

    /**
     * @return float
     */
    public function getConnectionTimeout(): float;

    /**
     * @return float
     */
    public function getReadWriteTimeout(): float;

    /**
     * @return null
     */
    public function getContext();

    /**
     * @return bool
     */
    public function isKeepalive(): bool;

    /**
     * @return int
     */
    public function getHeartbeat(): int;
}
