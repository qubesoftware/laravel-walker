<?php

declare(strict_types=1);

namespace Qube\Walker;

use Closure;
use Illuminate\Support\Arr;
use Qube\Walker\Contracts\Step;
use Qube\Walker\Contracts\Walker as Contract;
use Qube\Walker\Driver;
use Qube\Walker\Exceptions\InvalidStepException;
use Qube\Walker\Exceptions\StepsNotDefinedException;

class Walker implements Contract
{
    /**
     * The current step index.
     * 
     * @var int
     */
    protected int $currentStep = 0;

    /**
     * The walker data.
     * 
     * @var array<string, mixed>
     */
    protected array $data = [];

    /**
     * The list of steps to travel.
     * 
     * @var array<string, \Qube\Walker\Contracts\Step>
     */
    protected array $steps = [];

    /**
     * Create a new walker.
     */
    protected function __construct(
        protected string $name,
    ) {
        //
    }

    /**
     * Append the given data to the 
     * walker information.
     * 
     * @param  array<string, mixed>  $data
     * @return self
     */
    public function append(array $data): self
    {
        foreach (Arr::dot(array: $data) as $path => $value) {
            Arr::set(array: $this->data, key: $path, value: $value);
        }

        return $this->save();
    }

    /**
     * Return the walker data.
     * 
     * @return array<string, mixed>
     */
    public function data(): array
    {
        return $this->data;
    }

    /**
     * Navigate to the next step of the walker.
     * 
     * @param  \Closure  $next
     * @return mixed
     */
    public function next(Closure $next): mixed
    {
        // Call the defined method to be executed
        // before the walker moves to the previous step.
        $response = $this->step()->onBeforeNextStep(walker: $this);

        // If there isn't a response, that means we should move
        // to the next step, so we need to validate if it exists.
        if (! $response && ! $this->isValidStep(index: $this->currentStep + 1)) {
            throw new InvalidStepException;
        }

        $this->currentStep++;

        $this->save();

        return $response ? $response : $next();
    }

    /**
     * Navigate to the previous step of the walker.
     * 
     * @param  \Closure  $next
     * @return mixed
     */
    public function previous(Closure $next): mixed
    {
        // Call the defined method to be executed
        // before the walker moves to the previous step.
        $response = $this->step()->onBeforePreviousStep(walker: $this);

        // If there isn't a response, that means we should move
        // to the next step, so we need to validate if it exists.
        if (! $response && ! $this->isValidStep(index: $this->currentStep - 1)) {
            throw new InvalidStepException;
        }

        $this->currentStep--;

        $this->save();

        return $response ? $response : $next();
    }

    /**
     * Render the current walker's step.
     * 
     * @return mixed
     */
    public function render(): mixed
    {
        return $this->step()->render(walker: $this);
    }

    /**
     * Save the walker instance using the 
     * defined driver.
     * 
     * @return self
     */
    public function save(): self
    {
        Driver::put(key: $this->name, value: $this->toJson());

        return $this;
    }

    /**
     * Set the list of steps that the walker
     * will make.
     * 
     * @param  array<string, \Qube\Walker\Contracts\Step>  $steps
     * @return \Qube\Walker\Contracts\Walker
     */
    public function through(array $steps): self
    {
        // Validate that all the steps are correctly
        // defined by the developer.
        foreach ($steps as $step) {
            if (! (app($step) instanceof Step)) {
                throw new InvalidStepException;
            }
        }

        $this->steps = $steps;

        return $this->save();
    }
    
    /**
     * Check if there is a walker that exists
     * with the given name and load it, or
     * create a new walker.
     * 
     * @param  string  $name
     * @return \Qube\Walker\Contracts\Walker
     */
    public static function walk(string $name): self
    {
        // Check if the walker was already created
        // and load it from the driver.
        if (Driver::has(key: $name)) {
            return (new static(name: $name))->fromJson(
                json: Driver::get(key: $name)
            )->save();
        }

        return (new static(name: $name))->save();
    }

    /**
     * Given a JSON representation of the walker,
     * assign the properties.
     * 
     * @param  string  $json
     * @return array<string, mixed>
     */
    protected function fromJson(string $json): self
    {
        foreach (json_decode(json: $json, associative: true) as $property => $value) {
            $this->$property = $value;
        }

        return $this;
    }
    
    /**
     * Returns a boolean indicating if the
     * given step index is valid.
     * 
     * @param  int  $index
     * @return bool
     */
    protected function isValidStep(int $index): bool
    {
        return array_key_exists(key: $index, array: $this->steps);
    }

    /**
     * Return an instance of the current step
     * of the walker.
     * 
     * @return \Qube\Walker\Contracts\Step
     */
    protected function step(): Step
    {
        if (! $this->isValidStep($this->currentStep)) {
            throw new InvalidStepException;
        }

        return app($this->steps[$this->currentStep]);
    }

    /**
     * Return a JSON representation of the
     * walker instance.
     * 
     * @return string
     */
    public function toJson(): string
    {
        return json_encode(value: get_object_vars($this));
    }
}