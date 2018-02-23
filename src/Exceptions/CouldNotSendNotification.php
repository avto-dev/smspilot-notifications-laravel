<?php

namespace AvtoDev\SmsPilotNotificationsChanel\Exceptions;

use Exception;
use DomainException;

/**
 * Class CouldNotSendNotification.
 */
class CouldNotSendNotification extends Exception
{
    /**
     * Thrown when recipient's phone number is missing.
     *
     * @return static
     */
    public static function missingRecipient()
    {
        return new static('Notification was not sent. Phone number is missing.');
    }

    /**
     * Thrown when text is missing.
     *
     * @return static
     */
    public static function missingText()
    {
        return new static('Notification was not sent. Text is missing.');
    }

    /**
     * Service error returned.
     *
     * @param DomainException $exception
     *
     * @return static
     */
    public static function respondedWithAnError(DomainException $exception)
    {
        return new static(
            "Smspilot responded with an error '{$exception->getCode()}: {$exception->getMessage()}'"
        );
    }

    /**
     * Unable to communicate with server.
     *
     * @param Exception $exception
     *
     * @return static
     */
    public static function couldNotCommunicateWithServer(Exception $exception)
    {
        return new static("The communication with server failed. Reason: {$exception->getMessage()}");
    }
}
