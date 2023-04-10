<?php

namespace App\Steps;

use Qube\Walker\Contracts\Walker;
use Qube\Walker\Step;

class Step1 extends Step
{
    /**
     * Render the step.
     * 
     * @return mixed
     */
    public function render(Walker $walker): mixed
    {
        return view('walker/step-1');
    }

    /**
     * Callback executed before navigating to 
     * the next step.
     * 
     * @param  \Qube\Walker\Contracts\Walker  $walker
     * @return mixed
     */
    public function onBeforeNextStep(Walker $walker)
    {
        // Make some validations and append the data...
    }
}