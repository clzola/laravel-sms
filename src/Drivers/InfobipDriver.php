<?php

namespace clzola\Components\Sms\Drivers;

use clzola\Components\Sms\Exceptions\SmsException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\RequestOptions;

class InfobipDriver extends Driver
{
    /**
     * @var string Api key used to authenticate with Infobip service.
     */
    private $apiKey;


    /**
     * @var string A name that will be shown to end user.
     */
    private $senderName;


    /**
     * InfobipDriver constructor.
     * @param $apiKey
     * @param $senderName
     */
    public function __construct($apiKey, $senderName)
    {
        $this->apiKey = $apiKey;
        $this->senderName = $senderName;
    }


    /**
     * Send the given message to given recipient.
     *
     * @return void
     * @throws SmsException
     */
    public function send()
    {
        $client = new Client();

        try {
            $client->post('https://jkden.api.infobip.com/sms/2/text/single', [
                RequestOptions::HEADERS => $this->getHeaders(),
                RequestOptions::JSON => $this->getBody(),
            ]);
        } catch (ClientException $exception) {
            $statusCode = -1;
            if($exception->hasResponse())
                $statusCode = $exception->getResponse()->getStatusCode();
            throw new SmsException("Failed to send sms using infobip. Status code: $statusCode");
        } catch (\Exception $exception) {
            throw new SmsException("Failed to send sms using infobip.");
        }
    }


    protected function getHeaders()
    {
        return [
            "Authorization" => "App {$this->apiKey}",
        ];
    }


    protected function getBody()
    {
        return [
            "from" => config('sms.from'),
            "to" => $this->recipient,
            "text" => $this->message,
        ];
    }
}