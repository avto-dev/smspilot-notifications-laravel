<?php

namespace AvtoDev\SmsPilotNotifications\Tests;

use Exception;
use AvtoDev\SmsPilotNotifications\Exceptions\CannotSendMessage;
use AvtoDev\SmsPilotNotifications\Exceptions\HttpRequestException;
use AvtoDev\SmsPilotNotifications\Exceptions\InvalidResponseException;
use AvtoDev\SmsPilotNotifications\Exceptions\MissingNotificationRouteException;

/**
 * Class ExceptionsTest.
 */
class ExceptionsTest extends AbstractTestCase
{
    /**
     * Assert that exception is exists.
     *
     * @return void
     */
    public function testExceptionsIsExists()
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
        }
    }
}
