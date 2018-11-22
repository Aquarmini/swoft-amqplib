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

/**
 * 内存缓存引擎
 * Class Memory
 * @package Swoftx\Amqplib\CacheManager
 */
class Memory implements CacheInterface
{
    public static $data = [];

    public function set($key, $value)
    {
        static::$data[$key] = $value;
    }

    public function get($key, $value, $default)
    {
        return static::$data[$key] ?? $default;
    }

    public function has($key): bool
    {
        return isset(static::$data[$key]);
    }
}
