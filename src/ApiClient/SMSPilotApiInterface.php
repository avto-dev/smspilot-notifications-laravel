<?php

namespace AvtoDev\SmsPilotNotificationsChanel\ApiClient;

use AvtoDev\SmsPilotNotificationsChanel\SmsPilotHttpResponse;
use AvtoDev\SmsPilotNotificationsChanel\Exceptions\CannotSendMessage;
use AvtoDev\SmsPilotNotificationsChanel\Exceptions\HttpRequestException;
use AvtoDev\SmsPilotNotificationsChanel\Exceptions\InvalidResponseException;

/**
 * Interface SMSPilotApiInterface.
 */
interface SMSPilotApiInterface
{
    /**
     * Send SMS message.
     *
     * @param string $text      Text of the message to be sent
     * @param string $recipient Recipient of the message to be sent
     * @param array  $params    Additional request parameters
     *
     * @throws HttpRequestException
     * @throws InvalidResponseException
     * @throws CannotSendMessage
     *
     * @return SmsPilotHttpResponse
     */
    public function send($text, $recipient, array $params = []);
}
