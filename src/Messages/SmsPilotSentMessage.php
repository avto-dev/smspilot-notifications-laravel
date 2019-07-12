<?php

declare(strict_types = 1);

namespace AvtoDev\SmsPilotNotifications\Messages;

class SmsPilotSentMessage
{
    /**
     * Server ID.
     *
     * @var int
     */
    protected $server_id;

    /**
     * Phone number.
     *
     * @var string
     */
    protected $phone;

    /**
     * Price value.
     *
     * @var float
     */
    protected $price;

    /**
     * Status code.
     *
     * @var int
     */
    protected $status_code;

    /**
     * SentMessage constructor.
     *
     * @param int    $server_id
     * @param string $phone
     * @param float  $price
     * @param int    $status_code
     */
    public function __construct(int $server_id, string $phone, float $price, int $status_code)
    {
        $this->server_id   = $server_id;
        $this->phone       = $phone;
        $this->price       = $price;
        $this->status_code = $status_code;
    }

    /**
     * Convert status code into message.
     *
     * @param int|null $status_code
     *
     * @return string
     */
    public static function convertStatusCodeIntoMessage(?int $status_code): string
    {
        switch ($status_code) {
            case -2:
                return 'Error (invalid message length or phone number)';
            case -1:
                return 'Not delivered';
            case 0:
                return 'New message, preparation for sending';
            case 1:
                return 'In queue';
            case 2:
                return 'Delivered';
            case 3:
                return 'Deferred sending (set to send_datetime)';
        }

        return 'Unknown status code';
    }

    /**
     * Get server ID.
     *
     * @return int
     */
    public function getServerId(): int
    {
        return $this->server_id;
    }

    /**
     * Get phone number.
     *
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * Get price.
     *
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * Get status code.
     *
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->status_code;
    }

    /**
     * Get status message as a string.
     *
     * @return string
     */
    public function getStatus(): string
    {
        return self::convertStatusCodeIntoMessage($this->getStatusCode());
    }
}
