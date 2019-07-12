<?php

declare(strict_types = 1);

namespace AvtoDev\SmsPilotNotifications\ApiClient;

use AvtoDev\SmsPilotNotifications\Messages\SmsPilotMessage;
use AvtoDev\SmsPilotNotifications\Exceptions\CannotSendMessage;
use AvtoDev\SmsPilotNotifications\Exceptions\HttpRequestException;
use AvtoDev\SmsPilotNotifications\Exceptions\InvalidResponseException;
use AvtoDev\SmsPilotNotifications\ApiClient\Responses\MessageSentResponse;

interface ApiClientInterface
{
    /**
     * SmsPilotApi constructor.
     *
     * @param string $api_key             API key
     * @param string $default_sender_name Default sender name
     */
    public function __construct(string $api_key, string $default_sender_name);

    /**
     * Send SMS message.
     *
     * @param SmsPilotMessage $message
     *
     * @throws HttpRequestException
     * @throws InvalidResponseException
     * @throws CannotSendMessage
     *
     * @return MessageSentResponse
     */
    public function send(SmsPilotMessage $message);
}
