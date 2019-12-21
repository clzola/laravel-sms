<?php

namespace clzola\Components\Sms\Contracts;

interface SMS
{
    /**
     * Send the given message to given recipient.
     *
     * @return void
     */
    public function send();
}