<?php

declare(strict_types=1);

use Qube\Walker\Drivers\SessionDriver;

return [

    /*
    |--------------------------------------------------------------------------
    | Driver.
    |--------------------------------------------------------------------------
    |
    | This value defines the driver used to store the information.
    | By default, it uses the session driver, which maps to the defined
    | Laravel's session facade (so, it will use the defined Laravel's 
    | session driver).
    |
    | Values: \Qube\Walker\Drivers\SessionDriver::class,
    |
    */

    'driver' => SessionDriver::class,

];