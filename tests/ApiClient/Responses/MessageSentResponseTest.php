<?php

declare(strict_types = 1);

namespace AvtoDev\SmsPilotNotifications\Tests\ApiClient\Responses;

use GuzzleHttp\Psr7\Response;
use AvtoDev\SmsPilotNotifications\Tests\AbstractTestCase;
use AvtoDev\SmsPilotNotifications\Messages\SmsPilotSentMessage;
use AvtoDev\SmsPilotNotifications\Exceptions\InvalidResponseException;
use AvtoDev\SmsPilotNotifications\ApiClient\Responses\MessageSentResponse;

/**
 * @covers \AvtoDev\SmsPilotNotifications\ApiClient\Responses\MessageSentResponse<extended>
 */
class MessageSentResponseTest extends AbstractTestCase
{
    /**
     * Test passed to the constructor response accessor.
     *
     * @return void
     */
    public function testGetHttpResponse(): void
    {
        $response = new Response(200, ['foo' => 'bar'], '{}');
        $instance = new MessageSentResponse($response);

        $this->assertEquals($response, $instance->getHttpResponse());
    }

    /**
     * Test exception with passed invalid json-string in response object, passed into constructor.
     *
     * @return void
     */
    public function testExceptionWithInvalidJsonPassedIntoConstructor(): void
    {
        $this->expectException(InvalidResponseException::class);
        $this->expectExceptionMessageMatches('~Cannot decode~i');

        new MessageSentResponse(new Response(200, [], '{"foo":'));
    }

    /**
     * Test 'getBody' method.
     *
     * @return void
     */
    public function testGetBody(): void
    {
        $response = new Response(200, [], '{"foobar":"bar foo","some":{"inside":"key"}}');
        $instance = new MessageSentResponse($response);

        $this->assertEquals(['foobar' => 'bar foo', 'some' => ['inside' => 'key']], $instance->getBody());
        $this->assertEquals('bar foo', $instance->getBody('foobar'));
        $this->assertEquals('key', $instance->getBody('some.inside'));
        $this->assertEquals([1, 2], $instance->getBody('bla.bla', [1, 2]));
    }

    /**
     * Test any another data accessors methods.
     *
     * @return void
     */
    public function testDataAccessors(): void
    {
        $response = new Response(200, ['foo' => 'bar'], json_encode([
            'send'    => [
                $message_one = ['server_id' => 1, 'phone' => '81112223344', 'price' => 3.14, 'status' => 2],
                $message_two = ['server_id' => 2, 'phone' => '81112225566', 'price' => 1, 'status' => 1],
                ['server_id' => 3, 'phone' => '81112227788', 'wrong_here' => true],
            ],
            'balance' => $balance = 2233,
            'cost'    => $cost = 5.67,
        ]));
        $instance = new MessageSentResponse($response);

        $this->assertCount(2, $sent_messages = $instance->getSentMessages());
        $this->assertEquals($balance, $instance->getBalance());
        $this->assertEquals($cost, $instance->getCost());

        /** @var SmsPilotSentMessage $first_message */
        $first_message = $sent_messages[0];
        $this->assertEquals($message_one['server_id'], $first_message->getServerId());
        $this->assertEquals($message_one['phone'], $first_message->getPhone());

        /** @var SmsPilotSentMessage $second_messages */
        $second_messages = $sent_messages[1];
        $this->assertEquals($message_two['server_id'], $second_messages->getServerId());
        $this->assertEquals($message_two['phone'], $second_messages->getPhone());
    }
}
