<?php

namespace clzola\Components\Sms\Drivers;

use clzola\Components\Sms\Contracts\HasPhoneNumber;
use clzola\Components\Sms\Contracts\SMS;
use clzola\Components\Sms\Exceptions\SmsException;

abstract class Driver implements SMS
{
    /**
     * The recipient of the message.
     *
     * @var string
     */
    protected $recipient;


    /**
     * The message to send.
     *
     * @var string
     */
    protected $message;


    /**
     * {@inheritdoc}
     */
    abstract public function send();


    /**
     * Set the recipient of the message.
     *
     * @param string $recipient
     * @throws SmsException
     * @return $this
     */
    public function to($recipient)
    {
        throw_if(is_null($recipient), SmsException::class, 'Recipient cannot be empty');

        throw_if(!is_string($recipient) && $recipient instanceof HasPhoneNumber, SmsException::class, 'Invalid argument for recipient. Must be phone number (string) or entity that implements HasPhoneNumber interface.');

        $this->recipient = $recipient;

        return $this;
    }


    /**
     * Set the content of the message.
     *
     * @param string $message
     * @throws SmsException
     * @return $this
     */
    public function content($message)
    {
        throw_if(empty($message), SmsException::class, 'Message text is required');

        $this->message = $message;

        return $this;
    }

}