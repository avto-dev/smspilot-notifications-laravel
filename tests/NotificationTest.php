<?php

namespace AvtoDev\SmsPilotNotificationsChanel\Tests;

use Illuminate\Support\Facades\Notification;
use AvtoDev\SmsPilotNotificationsChanel\SmsPilotChannel;
use AvtoDev\SmsPilotNotificationsChanel\Tests\Examples\ExampleNotification;
use AvtoDev\SmsPilotNotificationsChanel\Tests\Examples\SmsNotificationReceiver;

/**
 * Class NotificationTest.
 *
 * @group feature
 */
class NotificationTest extends AbstractTestCase
{
    /**
     * Notification test.
     */
    public function testNotification()
    {
        Notification::fake();
        $smsNotificationReceiver = new SmsNotificationReceiver;

        $smsNotificationReceiver->notifyNow(new ExampleNotification);
        Notification::assertSentTo(
            $smsNotificationReceiver,
            ExampleNotification::class,
            function ($notification, $channels) use ($smsNotificationReceiver) {
                return $notification->toSms() === 'test2' && in_array(SmsPilotChannel::class, $channels);
            }
        );
    }
}
