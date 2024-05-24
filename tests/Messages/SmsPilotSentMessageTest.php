<?php

declare(strict_types = 1);

namespace AvtoDev\SmsPilotNotifications\Tests\Messages;

use AvtoDev\SmsPilotNotifications\Tests\AbstractTestCase;
use AvtoDev\SmsPilotNotifications\Messages\SmsPilotSentMessage;

/**
 * @covers \AvtoDev\SmsPilotNotifications\Messages\SmsPilotSentMessage
 */
class SmsPilotSentMessageTest extends AbstractTestCase
{
    /**
     * Test constructor arguments.
     *
     * @return void
     */
    public function testConstructor(): void
    {
        $instance = new SmsPilotSentMessage(
            $server_id = 1,
            $phone = '81112223344',
            $price = 3.14,
            $status_code = 0
        );

        $this->assertEquals($server_id, $instance->getServerId());
        $this->assertEquals($phone, $instance->getPhone());
        $this->assertEquals($price, $instance->getPrice());
        $this->assertEquals($status_code, $instance->getStatusCode());
        $this->assertEquals('New message, preparation for sending', $instance->getStatus());
    }

    /**
     * Test convert status code into status message.
     *
     * @return void
     */
    public function testConvertStatusCodeIntoMessage(): void
    {
        $map = [
            -2 => 'Error (invalid message length or phone number)',
            -1 => 'Not delivered',
            0  => 'New message, preparation for sending',
            1  => 'In queue',
            2  => 'Delivered',
            3  => 'Deferred sending (set to send_datetime)',

            100  => 'Unknown status code',
            -100 => 'Unknown status code',
        ];

        foreach ($map as $code => $description) {
            $this->assertEquals($description, SmsPilotSentMessage::convertStatusCodeIntoMessage($code));
        }
    }
}
