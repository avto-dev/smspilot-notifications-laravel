<?php

declare(strict_types = 1);

namespace AvtoDev\SmsPilotNotifications\Tests;

use AvtoDev\SmsPilotNotifications\SmsPilotChannel;
use AvtoDev\SmsPilotNotifications\ApiClient\ApiClient;

/**
 * @covers \AvtoDev\SmsPilotNotifications\SmsPilotServiceProvider<extended>
 */
class SmsPilotServiceProviderTest extends AbstractTestCase
{
    /**
     * @return void
     */
    public function testDI(): void
    {
        $channel = $this->app->make(SmsPilotChannel::class);

        $this->assertInstanceOf(SmsPilotChannel::class, $channel);

        $this->assertInstanceOf(
            ApiClient::class,
            $api_client = $this->getPropertyValue($channel, 'api_client')
        );
    }
}
