<?php

declare(strict_types = 1);

namespace AvtoDev\SmsPilotNotifications;

use InvalidArgumentException;
use Illuminate\Notifications\Notification;
use AvtoDev\SmsPilotNotifications\Messages\SmsPilotMessage;
use AvtoDev\SmsPilotNotifications\ApiClient\Responses\MessageSentResponse;
use AvtoDev\SmsPilotNotifications\Exceptions\MissingNotificationRouteException;
use AvtoDev\SmsPilotNotifications\ApiClient\ApiClientInterface as SmsPilotApiClient;

class SmsPilotChannel
{
    /**
     * @var SmsPilotApiClient
     */
    protected $api_client;

    /**
     * Create a new SMS Pilot channel instance.
     *
     * @param SmsPilotApiClient $api_client
     *
     * @return void
     */
    public function __construct(SmsPilotApiClient $api_client)
    {
        $this->api_client = $api_client;
    }

    /**
     * Send the given notification.
     *
     * @param mixed        $notifiable
     * @param Notification $notification
     *
     * @throws MissingNotificationRouteException
     * @throws InvalidArgumentException
     *
     * @return MessageSentResponse|null
     */
    public function send($notifiable, Notification $notification): ?MessageSentResponse
    {
        if (! $receiver_phone_number = $notifiable->routeNotificationFor('SmsPilot')) {
            return null;
        }

        if (! method_exists($notification, $route = 'toSmsPilot')) {
            throw new MissingNotificationRouteException(sprintf('Missing notification route "%s"', $route));
        }

        /** @var $message SmsPilotMessage */
        if (! (($message = $notification->{$route}($notifiable)) instanceof SmsPilotMessage)) {
            throw new InvalidArgumentException(\sprintf(
                'Route "%s" must returns object with instance of "%s"',
                $route,
                SmsPilotMessage::class
            ));
        }

        // Overwrite 'to' property, if route to the notification does not set it
        if ($message->to === null) {
            $message->to($receiver_phone_number);
        }

        return $this->api_client->send($message);
    }
}
