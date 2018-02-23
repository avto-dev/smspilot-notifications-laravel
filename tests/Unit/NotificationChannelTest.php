<?php

namespace AvtoDev\SmsPilotNotificationsChanel\Tests\Unit;

use Mockery;
use AvtoDev\SmsPilotNotificationsChanel\ApiClient\SmsPilotApi;
use AvtoDev\SmsPilotNotificationsChanel\SmsPilotChannel;
use AvtoDev\SmsPilotNotificationsChanel\Tests\AbstractTestCase;
use AvtoDev\SmsPilotNotificationsChanel\Tests\Examples\ExampleNotification;
use AvtoDev\SmsPilotNotificationsChanel\Tests\Examples\SmsNotificationReceiver;

class NotificationChannelTest extends AbstractTestCase
{
    /**
     * @var SmsPilotApi|Mockery\MockInterface
     */
    protected $client;

    /** @var ExampleNotification */
    protected $notification;

    /** @var SmsPilotChannel */
    protected $channel;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        parent::setUp();
        $this->client  = Mockery::mock(SmsPilotApi::class);
        $this->channel = new SmsPilotChannel($this->client);
    }

    /**
     * @throws \AvtoDev\SmsPilotNotificationsChanel\Exceptions\CouldNotSendNotification
     */
    public function testSendMessage()
    {
        $this->client->shouldReceive('send')->once();
        $this->channel->send(new SmsNotificationReceiver, new ExampleNotification);
    }

    /**
     * @throws \AvtoDev\SmsPilotNotificationsChanel\Exceptions\CouldNotSendNotification
     */
    public function testNoPhone()
    {
        $this->expectExceptionMessage('Notification was not sent. Phone number is missing.');
        $this->channel->send(new SmsNotificationReceiver(''), new ExampleNotification);
    }

    /**
     * @throws \AvtoDev\SmsPilotNotificationsChanel\Exceptions\CouldNotSendNotification
     */
    public function testNoText()
    {
        $this->expectExceptionMessage('Notification was not sent. Text is missing.');
        $this->channel->send(new SmsNotificationReceiver, new ExampleNotification(''));
    }
}
