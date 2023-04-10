<?php

namespace App\Steps;

use Qube\Walker\Contracts\Walker;
use Qube\Walker\Step;

class Step2 extends Step
{
    /**
     * Render the step.
     * 
     * @return mixed
     */
    public function render(Walker $walker): mixed
    {
        return view('walker/step-2');
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
        // As this is the final step of the Walker,
        // we should redirect the user outside of it.
        return redirect('/finish');
    }
}