<?php

declare(strict_types=1);

namespace Qube\Walker;

use Qube\Walker\Contracts\Step as Contract;
use Qube\Walker\Contracts\Walker;

abstract class Step implements Contract
{
    /**
     * Render the step.
     * 
     * @param  \Qube\Walker\Contracts\Walker  $walker
     * @return mixed
     */
    abstract public function render(Walker $walker): mixed;

    /**
     * Callback executed before navigating to 
     * the next step.
     * 
     * @param  \Qube\Walker\Contracts\Walker
     * @return mixed
     */
    public function onBeforeNextStep(Walker $walker)
    {
        // 
    }

    /**
     * Callback executed before navigating to 
     * the previous step.
     * 
     * @param  \Qube\Walker\Contracts\Walker
     * @return mixed
     */
    public function onBeforePreviousStep(Walker $walker)
    {
        // 
    }
}