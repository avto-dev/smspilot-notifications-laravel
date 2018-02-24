<?php

namespace AvtoDev\SmsPilotNotificationsChanel;

use Illuminate\Notifications\Notification;
use AvtoDev\SmsPilotNotificationsChanel\ApiClient\SmsPilotApi;
use AvtoDev\SmsPilotNotificationsChanel\Exceptions\CouldNotSendNotification;

/**
 * Class SmsPilotChannel.
 *
 * Sms pilot notification channel
 */
class SmsPilotChannel
{
    /**
     * @var SmsPilotApi
     */
    protected $api;

    public function __construct(SmsPilotApi $api)
    {
        $this->api = $api;
    }

    /**
     * Send the given notification.
     *
     * @param mixed        $notifiable
     * @param Notification $notification
     *
     * @throws CouldNotSendNotification
     */
    public function send($notifiable, Notification $notification)
    {
        $to = $notifiable->routeNotificationFor('sms');

        if (empty($to)) {
            throw CouldNotSendNotification::missingRecipient();
        }

        $text = $notification->toSms();

        if (empty($text)) {
            throw CouldNotSendNotification::missingText();
        }

        $this->getApi()->send($text, $to);
    }

    /**
     * @return SmsPilotApi
     */
    protected function getApi()
    {
        return $this->api;
    }
}
