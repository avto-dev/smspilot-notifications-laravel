<?php

namespace AvtoDev\SmsPilotNotificationsChanel\Tests\Traits;

use Illuminate\Support\Arr;
use GuzzleHttp\Handler\MockHandler;
use AvtoDev\SmsPilotNotificationsChanel\Tests\AbstractTestCase;
use AvtoDev\SmsPilotNotificationsChanel\SmsPilotNotificationsServiceProvider;

/**
 * Trait RegisterServiceProviderTrait.
 *
 * @mixin AbstractTestCase
 */
trait RegisterServiceProviderTrait
{
    public function registerProvider()
    {
        $config = require __DIR__ . '/../config/sms-pilot.php';

        $config = Arr::set($config, 'http_client_config.handler', $this->getHandler());

        $this->app->make('config')->set('sms_pilot', $config);
        $this->app->register(SmsPilotNotificationsServiceProvider::class);
    }

    /**
     * @return MockHandler
     */
    abstract protected function getHandler();
}
