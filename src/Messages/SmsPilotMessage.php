<?php

declare(strict_types = 1);

namespace AvtoDev\SmsPilotNotifications\Messages;

use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Contracts\Support\Arrayable;

/**
 * @implements Arrayable<string, mixed>
 */
class SmsPilotMessage implements Jsonable, Arrayable
{
    /**
     * The text content of the message.
     *
     * @var string|null
     */
    public ?string $content = null;

    /**
     * Receiver phone number.
     *
     * @var string|null
     */
    public ?string $to = null;

    /**
     * Sender name. Leave 'null' for using value from settings.
     *
     * @see https://smspilot.ru/my-sender.php
     *
     * @var string|null
     */
    public ?string $from = null;

    /**
     * Set a sender name.
     *
     * @param string $sender_name
     *
     * @return $this
     */
    public function from(string $sender_name): self
    {
        $this->from = $sender_name;

        return $this;
    }

    /**
     * Set receiver phone number (the message should be sent to).
     *
     * @param string $phone_number
     *
     * @return $this
     */
    public function to(string $phone_number): self
    {
        $this->to = $phone_number;

        return $this;
    }

    /**
     * Set the content of SMS message.
     *
     * @param string $content
     *
     * @return $this
     */
    public function content(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function toJson($options = 0): string
    {
        return (string) \json_encode($this->toArray(), $options);
    }

    /**
     * Get the instance as an array.
     *
     * @return array{content: ?string, to: ?string, from: ?string}
     */
    public function toArray(): array
    {
        return [
            'content' => $this->content,
            'to'      => $this->to,
            'from'    => $this->from,
        ];
    }
}
