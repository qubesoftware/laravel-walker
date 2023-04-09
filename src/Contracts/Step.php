<?php

declare(strict_types=1);

namespace Qube\Walker\Contracts;

interface Step
{
    /**
     * Render the step.
     * 
     * @param  \Qube\Walker\Contracts\Walker  $walker
     * @return mixed
     */
    public function render(Walker $walker): mixed;

    /**
     * Callback executed before navigating to 
     * the next step.
     * 
     * @param  \Qube\Walker\Contracts\Walker  $walker
     * @return mixed
     */
    public function onBeforeNextStep(Walker $walker);

    /**
     * Callback executed before navigating to 
     * the previous step.
     * 
     * @param  \Qube\Walker\Contracts\Walker  $walker
     * @return mixed
     */
    public function onBeforePreviousStep(Walker $walker);
}