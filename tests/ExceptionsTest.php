<?php

declare(strict_types = 1);

namespace AvtoDev\SmsPilotNotifications\Tests;

use Exception;
use AvtoDev\SmsPilotNotifications\Exceptions\CannotSendMessage;
use AvtoDev\SmsPilotNotifications\Exceptions\HttpRequestException;
use AvtoDev\SmsPilotNotifications\Exceptions\InvalidResponseException;
use AvtoDev\SmsPilotNotifications\Exceptions\SmsPilotExceptionInterface;
use AvtoDev\SmsPilotNotifications\Exceptions\MissingNotificationRouteException;

/**
 * @covers \AvtoDev\SmsPilotNotifications\Exceptions\CannotSendMessage
 * @covers \AvtoDev\SmsPilotNotifications\Exceptions\HttpRequestException
 * @covers \AvtoDev\SmsPilotNotifications\Exceptions\InvalidResponseException
 * @covers \AvtoDev\SmsPilotNotifications\Exceptions\MissingNotificationRouteException
 */
class ExceptionsTest extends AbstractTestCase
{
    /**
     * Assert that exception is exists.
     *
     * @return void
     */
    public function testExceptionsIsExists(): void
    {
        $classes = [
            CannotSendMessage::class,
            HttpRequestException::class,
            InvalidResponseException::class,
            MissingNotificationRouteException::class,
        ];

        foreach ($classes as $class) {
            $this->assertTrue(class_exists($class));
            $this->assertInstanceOf(Exception::class, new $class);
            $this->assertInstanceOf(SmsPilotExceptionInterface::class, new $class);
        }
    }
}
