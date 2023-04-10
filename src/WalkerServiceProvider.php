<?php

declare(strict_types=1);

namespace Qube\Walker;

use Qube\Walker\Contracts\Driver;
use Illuminate\Support\ServiceProvider;

class WalkerServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     * 
     * @return void
     */
    public function register(): void
    {
        // Merge the config file with the published one.
        $this->mergeConfigFrom(
            __DIR__.'/../config/walker.php',
            'walker'
        );
    }

    /**
     * Handle the booting of the service provider.
     * 
     * @return void
     */
    public function boot(): void
    {        
        // Publish the configuration.
        $this->publishes([
            __DIR__.'/../config/walker.php' => config_path('walker.php')
        ], 'walker-config');

        // Register the commands.
        $this->commands([
            \Qube\Walker\Console\Commands\MakeStepCommand::class,
        ]); 
    }
}