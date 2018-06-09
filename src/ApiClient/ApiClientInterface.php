<?php

namespace AvtoDev\SmsPilotNotifications\ApiClient;

use AvtoDev\SmsPilotNotifications\Messages\SmsPilotMessage;
use AvtoDev\SmsPilotNotifications\Exceptions\CannotSendMessage;
use AvtoDev\SmsPilotNotifications\Exceptions\HttpRequestException;
use AvtoDev\SmsPilotNotifications\Exceptions\InvalidResponseException;

interface ApiClientInterface
{
    /**
     * SmsPilotApi constructor.
     *
     * @param string $api_key             API key
     * @param string $default_sender_name Default sender name
     */
    public function __construct($api_key, $default_sender_name);

    /**
     * Send SMS message.
     *
     * @param SmsPilotMessage $message
     *
     * @throws HttpRequestException
     * @throws InvalidResponseException
     * @throws CannotSendMessage
     *
     * @return Responses\MessageSentResponse
     */
    public function send(SmsPilotMessage $message);
}
