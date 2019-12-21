<?php

namespace clzola\Components\Sms\Drivers;

class NullDriver extends Driver
{
    /**
     * Discards message.
     */
    public function send()
    {
        return [];
    }
}