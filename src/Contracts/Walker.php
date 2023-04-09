<?php

declare(strict_types=1);

namespace Qube\Walker\Contracts;

use Closure;

interface Walker
{
    /**
     * Append the given data to the 
     * walker information.
     * 
     * @param  array<string, mixed>  $data
     * @return mixed
     */
    public function append(array $data): mixed;

    /**
     * Return the walker data.
     * 
     * @return array<string, mixed>
     */
    public function data(): array;

    /**
     * Navigate to the next step of the walker.
     * 
     * @param  \Closure  $next
     * @return mixed
     */
    public function next(Closure $next): mixed;

    /**
     * Navigate to the previous step of the walker.
     * 
     * @param  \Closure  $next
     * @return mixed
     */
    public function previous(Closure $next): mixed;

    /**
     * Render the current walker's step.
     * 
     * @return mixed
     */
    public function render(): mixed;

    /**
     * Save the walker instance using the 
     * defined driver.
     * 
     * @return self
     */
    public function save(): self;    

    /**
     * Set the list of steps that the walker
     * will make.
     * 
     * @param  array<string, \Qube\Walker\Contracts\Step>  $steps
     * @return \Qube\Walker\Contracts\Walker
     */
    public function through(array $steps): self;

    /**
     * Check if there is a walker that exists
     * with the given name and load it, or
     * create a new walker.
     * 
     * @param  string  $name
     * @return \Qube\Walker\Contracts\Walker
     */
    public static function walk(string $name): self;
}