<?php

namespace clzola\Components\Sms;

use clzola\Components\Sms\Drivers\NullDriver;
use Illuminate\Support\Manager;

class SmsManager extends Manager
{
    /**
     * Get a driver instance.
     *
     * @param  string|null  $name
     * @return \clzola\Components\Sms\Drivers\Driver
     */
    public function channel($name = null)
    {
        return $this->driver($name);
    }


    /**
     * Creates null driver instance.
     *
     * @return NullDriver
     */
    public function createNullDriver()
    {
        return new NullDriver();
    }


    /**
     * Get the default driver name.
     *
     * @return string
     */
    public function getDefaultDriver()
    {
        return "null";
    }
}