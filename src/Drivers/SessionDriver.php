<?php

declare(strict_types=1);

namespace Qube\Walker\Drivers;

use Qube\Walker\Contracts\Driver;
use Illuminate\Support\Facades\Session;

class SessionDriver extends Session implements Driver
{
    /**
     * Check if the given key exists as a walker
     * using the driver.
     * 
     * @param  string|array  $key
     * @return bool
     */
    public static function has(string|array $key): bool
    {
        return parent::has(key: $key);
    }

    /**
     * Save the given data to the given key using
     * the driver.
     * 
     * @param  string|array  $key
     * @param  mixed  $value
     * @return void
     */
    public static function put(string|array $key, mixed $value = null): void
    {
        tap(session())->put(key: $key, value: $value)->save();
    }

    /**
     * Get the data from the driver that corresponds
     * to the given key.
     * 
     * @param  string  $key
     * @param  mixed  $default
     * @return void
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        return parent::get(key: $key, default: $default);
    }
}