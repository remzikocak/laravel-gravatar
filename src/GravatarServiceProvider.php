<?php

namespace RKocak\Gravatar;

use Illuminate\Support\ServiceProvider;

class GravatarServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            dirname(__DIR__).'/config/gravatar.php' => config_path('gravatar.php'),
        ]);
    }

    /**
     * @return void
     */
    public function register()
    {
        $this->app->singleton('gravatar', function ($app) {
            return new Generator($app['config']);
        });
    }

    /**
     * @return array
     */
    public function provides()
    {
        return ['gravatar'];
    }
}
