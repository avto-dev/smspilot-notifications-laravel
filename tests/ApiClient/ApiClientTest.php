<?php

namespace AvtoDev\SmsPilotNotifications\Tests\ApiClient;

use AvtoDev\SmsPilotNotifications\Exceptions\CannotSendMessage;
use AvtoDev\SmsPilotNotifications\Exceptions\HttpRequestException;
use AvtoDev\SmsPilotNotifications\Exceptions\InvalidResponseException;
use AvtoDev\SmsPilotNotifications\Messages\SmsPilotMessage;
use AvtoDev\SmsPilotNotifications\Tests\AbstractTestCase;
use GuzzleHttp\Psr7\Response;

/**
 * Class ApiClientTest.
 */
class ApiClientTest extends AbstractTestCase
{
    /**
     * Test send method with wrong (invalid) server json response.
     *
     * @return void
     */
    public function testSendWithWrongJsonResponse()
    {
        $this->expectException(InvalidResponseException::class);

        $client = new ApiClientMock('foo', 'bar', [
            new Response(200, [], '{"some":foo'),
        ]);

        $client->send(SmsPilotMessage::create());
    }

    /**
     * Test send method with empty server json response.
     *
     * @return void
     */
    public function testSendWitEmptyJsonResponse()
    {
        $this->expectException(InvalidResponseException::class);

        $client = new ApiClientMock('foo', 'bar', [
            new Response(200, [], '{}'),
        ]);

        $client->send(SmsPilotMessage::create());
    }

    /**
     * Test send method with server error (exception).
     *
     * @return void
     */
    public function testSendWithWrongServerError()
    {
        $this->expectException(HttpRequestException::class);
        $this->expectExceptionCode(501);

        $client = new ApiClientMock('foo', 'bar', [
            new Response(501, [], 'Server error'),
        ]);

        $client->send(SmsPilotMessage::create());
    }

    /**
     * Test send method with server response which contains data about error.
     *
     * @return void
     */
    public function testSendWithResponseContainsError()
    {
        $this->expectException(CannotSendMessage::class);
        $this->expectExceptionCode(666);
        $this->expectExceptionMessageRegExp('/Error desc.*666/i');

        $client = new ApiClientMock('foo', 'bar', [
            new Response(200, [], '{"error":{"code":666,"description":"Error desc"}}'),
        ]);

        $client->send(SmsPilotMessage::create());
    }

    /**
     * Test send method with server response which contains wrong data about error.
     *
     * @return void
     */
    public function testSendWithResponseContainsWrongError()
    {
        $this->expectException(CannotSendMessage::class);
        $this->expectExceptionCode(0);
        $this->expectExceptionMessageRegExp('/Unavailable.*code.*0/i');

        $client = new ApiClientMock('foo', 'bar', [
            new Response(200, [], '{"error":{"code":false,"description":false}}'),
        ]);

        $client->send(SmsPilotMessage::create());
    }

    /**
     * Test send method with normal server response.
     *
     * @return void
     */
    public function testSendWithNormalResponse()
    {
        $client = new ApiClientMock('foo', 'bar', [
            new Response(200, [], sprintf(
                '{"send":[{"server_id":"%d","phone":"%s","price":"%02.2f", "status":"%d"}],"balance":"%02.2f","cost":"%d"}',
                $server_id = 666,
                $to = '81112223344',
                $price = 2.26,
                $status = 0,
                $balance = 28.00,
                $cost = 2
            )),
        ]);

        $response = $client->send(
            SmsPilotMessage::create()
                ->from($from = 'some sender')
                ->content($content = 'some content')
                ->to($to)
        );

        $message = $response->getSentMessages()[0];

        $this->assertEquals($server_id, $message->getServerId());
        $this->assertEquals($price, $message->getPrice());
        $this->assertEquals($to, $message->getPhone());
        $this->assertEquals($status, $message->getStatusCode());
        $this->assertEquals($balance, $response->getBalance());
        $this->assertEquals($cost, $response->getCost());
    }
}
