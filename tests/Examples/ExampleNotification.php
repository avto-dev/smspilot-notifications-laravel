<?php

namespace AvtoDev\SmsPilotNotificationsChanel\Tests\Examples;

use Illuminate\Notifications\Notification;
use AvtoDev\SmsPilotNotificationsChanel\SmsPilotChannel;

class ExampleNotification extends Notification
{
    /**
     * @var string
     */
    protected $text = 'test2';

    public function __construct($text = 'test2')
    {
        $this->text = $text;
    }

    public function via()
    {
        return [SmsPilotChannel::class];
    }

    public function toSms()
    {
        return $this->text;
    }
}
