<?php

namespace clzola\Components\Sms;

use clzola\Components\Sms\Drivers\AndroidEmulatorDriver;
use clzola\Components\Sms\Drivers\NullDriver;
use clzola\Components\Sms\Exceptions\SmsException;
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
     * Creates android emulator driver instance.
     *
     * @return AndroidEmulatorDriver
     * @throws SmsException
     */
    public function createEmulatorDriver()
    {
        preg_match_all('/^[+]?[0-9]*$/m', $this->config["sms.from"], $matches, PREG_SET_ORDER, 0);

        if(empty($matches)) {
            throw new SmsException("Bad phone number format, must be [+](0-9)*");
        }

        return new AndroidEmulatorDriver(
            $this->config["sms.drivers.emulator.android_sdk_path"],
            $this->config["sms.from"]
        );
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
        return $this->config["sms.default"];
    }
}