<?php

namespace clzola\Components\Sms;

use clzola\Components\Sms\Console\Commands\SendSms;
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

        if ($this->app->runningInConsole()) {
            $this->commands([
                SendSms::class,
            ]);
        }
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
