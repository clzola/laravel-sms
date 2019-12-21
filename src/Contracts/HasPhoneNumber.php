<?php

namespace clzola\Components\Sms\Contracts;

interface HasPhoneNumber
{
    /**
     * Returns phone number associated with entity.
     *
     * @return string
     */
    function getPhoneNumber();
}