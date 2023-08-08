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
        // $this->publishes([
        //     __DIR__.'/../config/allGeneratorConfig.php' => config_path('allGeneratorConfig.php'),
        // ], 'all-generator-config');

        // $this->publishes([
        //     __DIR__.'/../resources/views/' => resource_path('views/vendor/all-generator'),
        // ], 'all-generator-config');

        // $this->publishes([
        //     __DIR__.'/../public' => public_path('vendor/all-generator'),
        // ], 'public');

        $this->publishes([
            __DIR__ . '/../config/allGeneratorConfig.php' => config_path('allGeneratorConfig.php'),
            __DIR__ . '/../resources/views/' => resource_path('views/vendor/all-generator'),
            __DIR__ . '/../public' => public_path('vendor/all-generator'),
        ], 'all-generate');

        if ($this->app->runningInConsole()) {
            $this->commands([
                Generate::class
            ]);
        }

        $this->loadRoutesFrom(__DIR__ . "/routes/web.php");
        $this->loadViewsFrom(__DIR__ . "/../resources/views", "allGenerate");
    }
}
