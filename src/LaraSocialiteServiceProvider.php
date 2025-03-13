<?php

namespace Lopatin96\LaraSocialite;

use Illuminate\Support\ServiceProvider;

class LaraSocialiteServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/lara-socialite.php', 'lara-socialite'
        );
    }

    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/lara-socialite.php' => config_path('lara-socialite.php'),
        ], 'lara-socialite-config');

        $this->publishesMigrations([
            __DIR__ . '/../database/migrations' => database_path('migrations'),
        ], 'lara-socialite-migrations');

        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');

        $this->loadTranslationsFrom(__DIR__ . '/../lang', 'lara-socialite');

        $this->publishes([
            __DIR__ . '/../lang' => $this->app->langPath('vendor/lara-socialite'),
        ], 'lara-socialite-lang');

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'lara-socialite');

        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/lara-socialite'),
        ], 'lara-socialite-views');
    }
}
