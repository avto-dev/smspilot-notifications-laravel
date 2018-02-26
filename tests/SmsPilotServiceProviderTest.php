<?php

namespace AvtoDev\SmsPilotNotifications\Tests;

use AvtoDev\SmsPilotNotifications\SmsPilotChannel;

/**
 * Class SmsPilotServiceProviderTest.
 */
class SmsPilotServiceProviderTest extends AbstractTestCase
{
    /**
     * Test Laravel DI.
     *
     * @return void
     */
    public function testDI()
    {
        $channel = $this->app->make(SmsPilotChannel::class);

        $this->assertInstanceOf(SmsPilotChannel::class, $channel);
    }
}
