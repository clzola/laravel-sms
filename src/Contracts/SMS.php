<?php

namespace clzola\Components\Sms\Contracts;

interface SMS
{
    /**
     * Send the given message to given recipient.
     *
     * @return mixed
     */
    public function send();
}