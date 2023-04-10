<?php

namespace App\Http\Controllers;

use Qube\Walker\Walker;

class WalkerController extends Controller
{
    /**
     * Render the current walker step.
     */
    public function show()
    {
        // Setup the walker and render the current step.
        return Walker::walk(name: 'my-first-walker')->through([
            App\Steps\Step1::class,
            App\Steps\Step2::class,
        ])->render();
    }

    /**
     * Navigate to the next step of the flow.
     */
    public function next()
    {
        return Walker::walk(name: 'my-first-walker')->next(
            fn () => redirect('/walker')
        );
    }

    /**
     * Navigate to the previous step of the flow.
     */
    public function previous()
    {
        return Walker::walk(name: 'my-first-walker')->next(
            fn () => redirect('/walker')
        );
    }
}
