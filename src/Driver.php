<?php

declare(strict_types=1);

namespace Qube\Walker;

use Qube\Walker\Contracts\Driver as Contract;

class Driver implements Contract
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
        return config('walker.driver')::has(key: $key);
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
        config('walker.driver')::put(key: $key, value: $value);
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
        return config('walker.driver')::get(key: $key, default: $default);
    }
}