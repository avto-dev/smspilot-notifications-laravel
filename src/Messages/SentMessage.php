<?php

namespace AvtoDev\SmsPilotNotificationsChanel\Messages;

/**
 * Class SentMessage.
 *
 * Sent message object.
 */
class SentMessage implements MessageInterface
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
     * Convert status code into message.
     *
     * @param int|null $status_code
     *
     * @return string
     */
    public static function convertStatusCodeIntoMessage($status_code = null)
    {
        switch ((int) $status_code) {
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
     * SentMessage constructor.
     *
     * @param int    $server_id
     * @param string $phone
     * @param float  $price
     * @param int    $status_code
     */
    public function __construct($server_id, $phone, $price, $status_code)
    {
        $this->server_id   = (int) $server_id;
        $this->phone       = (string) $phone;
        $this->price       = (float) $price;
        $this->status_code = (int) $status_code;
    }

    /**
     * {@inheritdoc}
     */
    public function getServerId()
    {
        return $this->server_id;
    }

    /**
     * {@inheritdoc}
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Get price.
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * {@inheritdoc}
     */
    public function getStatusCode()
    {
        return $this->status_code;
    }

    /**
     * {@inheritdoc}
     */
    public function getStatus()
    {
        return self::convertStatusCodeIntoMessage($this->getStatusCode());
    }
}
