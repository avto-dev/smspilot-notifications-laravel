<?php

namespace AvtoDev\SmsPilotNotifications\Tests;

use AvtoDev\SmsPilotNotifications\SmsPilotChannel;
use AvtoDev\SmsPilotNotifications\ApiClient\ApiClient;

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
        $this->assertInstanceOf(
            ApiClient::class,
            $api_client = $this->getPropertyValue($channel, 'api_client')
        );
    }
}
