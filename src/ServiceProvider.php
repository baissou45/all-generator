<?php

namespace Baiss\ViewGenerator;

use Baiss\ViewGenerator\Commands\Generate;
use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;

class ServiceProvider extends IlluminateServiceProvider {

    public function register() {
        $this->mergeConfigFrom(
            __DIR__.'/../config/allGeneratorConfig.php', 'allGeneratorConfig'
        );
    }

    public function boot() {
        $this->publishes([
            __DIR__.'/../config/allGeneratorConfig.php' => config_path('allGeneratorConfig.php'),
        ], 'all-generator-config');

        if ($this->app->runningInConsole()) {
            $this->commands([
                Generate::class
            ]);
        }

        $this->loadRoutesFrom(__DIR__ . "/routes/web.php");
    }
}
