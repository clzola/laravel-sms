<?php

namespace clzola\Components\Sms;

use Illuminate\Support\ServiceProvider;

class SmsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/sms.php', 'sms'
        );

        $this->app->singleton('sms', function ($app) {
            return new SmsManager($app);
        });
    }


    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/sms.php' => config_path('sms.php'),
        ], 'config');
    }


    /**
     * Get the services provided by provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['sms'];
    }
}
