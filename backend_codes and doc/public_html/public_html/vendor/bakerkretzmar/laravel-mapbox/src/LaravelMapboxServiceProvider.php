<?php

namespace Bakerkretzmar\LaravelMapbox;

use Illuminate\Support\ServiceProvider;

class LaravelMapboxServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/laravel-mapbox.php' => config_path('laravel-mapbox.php'),
        ]);
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/laravel-mapbox.php', 'laravel-mapbox');

        $this->app->singleton(Mapbox::class, function () {
            return new Mapbox(config('laravel-mapbox'));
        });

        $this->app->alias(Mapbox::class, 'mapbox');
    }
}
