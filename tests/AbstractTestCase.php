<?php

namespace AvtoDev\SmsPilotNotificationsChanel\Tests;

use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Handler\MockHandler;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use AvtoDev\SmsPilotNotificationsChanel\Tests\Examples\SmsNotificationReceiver;

/**
 * Class AbstractTestCase.
 */
abstract class AbstractTestCase extends BaseTestCase
{
    use Traits\CreatesApplicationTrait,
        Traits\AdditionalAssertsTrait,
        Traits\RegisterServiceProviderTrait;

    protected function setUp()
    {
        parent::setUp();
        $this->registerProvider();
    }

    protected function getHandler()
    {
        $response = new Response(
            200,
            [],
            sprintf(
                '{"send":[
                {"server_id":"666","phone":"%s","price":"2.26", "status":"0"},
                {"server_id":"666","phone":"%s","price":"2.26", "status":"15"}
                ],"balance":"2800.00","cost":"2"}',
                (new SmsNotificationReceiver)->routeNotificationForSms(),
                (new SmsNotificationReceiver)->routeNotificationForSms()
            )
        );
        $handler  = new MockHandler(
            [$response]
        );

        return $handler;
    }
}
