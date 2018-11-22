<?php
/**
 * This file is part of Swoft.
 *
 * @link     https://swoft.org
 * @document https://doc.swoft.org
 * @contact  limingxin@swoft.org
 * @license  https://github.com/swoft-cloud/swoft/blob/master/LICENSE
 */

namespace Swoftx\Amqplib\CacheManager;

interface CacheInterface
{
    public function set($key, $value);

    public function get($key, $default = null);

    public function has($key): bool;
}
