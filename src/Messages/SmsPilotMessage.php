<?php

namespace AvtoDev\SmsPilotNotifications\Messages;

/**
 * Class SmsPilotMessage.
 *
 * SMS message object for SMS Pilot notifications channel.
 */
class SmsPilotMessage
{
    /**
     * The text content of the message.
     *
     * @var string|null
     */
    public $content;

    /**
     * Receiver phone number.
     *
     * @var string|null
     */
    public $phone_number;

    /**
     * Receiver phone number. Leave 'null' for using value from settings.
     *
     * @see https://smspilot.ru/my-sender.php
     *
     * @var string|null
     */
    public $sender_name;

    /**
     * Static factory method.
     *
     * @return static|self
     */
    public static function create(...$arguments)
    {
        return new static(...$arguments);
    }

    /**
     * Set a sender name.
     *
     * @param string $sender_name
     *
     * @return static|self
     */
    public function from($sender_name)
    {
        $this->sender_name = (string) $sender_name;

        return $this;
    }

    /**
     * Set receiver phone number (the message should be sent to).
     *
     * @param string $phone_number
     *
     * @return static|self
     */
    public function to($phone_number)
    {
        $this->phone_number = (string) $phone_number;

        return $this;
    }

    /**
     * Set the content of SMS message.
     *
     * @param string $content
     *
     * @return static|self
     */
    public function content($content)
    {
        $this->content = (string) $content;

        return $this;
    }
}
