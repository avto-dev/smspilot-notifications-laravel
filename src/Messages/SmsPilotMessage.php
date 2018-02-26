<?php

namespace AvtoDev\SmsPilotNotifications\Messages;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;

/**
 * Class SmsPilotMessage.
 *
 * SMS message object for SMS Pilot notifications channel.
 */
class SmsPilotMessage implements Jsonable, Arrayable
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
    public $to;

    /**
     * Sender name. Leave 'null' for using value from settings.
     *
     * @see https://smspilot.ru/my-sender.php
     *
     * @var string|null
     */
    public $from;

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
        $this->from = (string) $sender_name;

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
        $this->to = (string) $phone_number;

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

    /**
     * {@inheritdoc}
     */
    public function toJson($options = 0)
    {
        return json_encode($this->toArray(), $options);
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        return [
            'content' => $this->content,
            'to'      => $this->to,
            'from'    => $this->from,
        ];
    }
}
