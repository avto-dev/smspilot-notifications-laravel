<?php

namespace AvtoDev\SmsPilotNotificationsChanel\Tests\Unit;

use GuzzleHttp\Handler\MockHandler;
use AvtoDev\SmsPilotNotificationsChanel\Messages\SentMessage;
use AvtoDev\SmsPilotNotificationsChanel\ApiClient\SmsPilotApi;
use AvtoDev\SmsPilotNotificationsChanel\Tests\AbstractTestCase;

class ApiTest extends AbstractTestCase
{
    /**
     * @throws \AvtoDev\SmsPilotNotificationsChanel\Exceptions\CouldNotSendNotification
     * @throws \PHPUnit\Framework\ExpectationFailedException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     */
    public function testApiSuccess()
    {
        /** @var SmsPilotApi $api */
        $api = $this->app->make(SmsPilotApi::class);

        $response = $api->send('test', '79999999999');

        $this->assertEquals(2, $response->getCost());

        $this->assertEquals(2800, $response->getBalance());

        foreach ($response->getSandedMessages() as $sanded_message) {
            $this->assertInstanceOf(SentMessage::class, $sanded_message);

            if ($sanded_message->getStatusCode() === 0) {
                $this->assertEquals(0, $sanded_message->getStatusCode());
                $this->assertEquals('новое сообщение, подготовка к отправке', $sanded_message->getStatus());
            } elseif ($sanded_message->getStatusCode() === 15) {
                $this->assertEquals(15, $sanded_message->getStatusCode());
                $this->assertEquals('Undefined', $sanded_message->getStatus());
            }

            $this->assertEquals(2.26, $sanded_message->getPrice());
            $this->assertEquals(666, $sanded_message->getServerId());
            $this->assertEquals('79999999999', $sanded_message->getPhone());
        }
    }

    /**
     * @throws \AvtoDev\SmsPilotNotificationsChanel\Exceptions\CouldNotSendNotification
     * @throws \InvalidArgumentException
     */
    public function testErrorDomain()
    {
        $this->expectExceptionMessage('Smspilot responded with an error \'500: test\'');
        $handler = new MockHandler([
            new \DomainException('test', 500),
        ]);
        $this->send($handler);
    }

    /**
     * @throws \AvtoDev\SmsPilotNotificationsChanel\Exceptions\CouldNotSendNotification
     * @throws \InvalidArgumentException
     */
    public function testErrorException()
    {
        $this->expectExceptionMessage('The communication with server failed. Reason: test');
        $handler = new MockHandler([
            new \Exception('test', 500),
        ]);
        $this->send($handler);
    }

    /**
     * @throws \AvtoDev\SmsPilotNotificationsChanel\Exceptions\CouldNotSendNotification
     * @throws \InvalidArgumentException
     */
    public function testErrorResponse()
    {
        $this->expectExceptionMessage('Smspilot responded with an error \'111: Invalid phone\'');
        $handler = new MockHandler([
            new \GuzzleHttp\Psr7\Response(
                200,
                [],
                '{"error": {
                "code": "111",
                 "description": "Invalid phone",
                  "description_ru": "Неправильный номер телефона"
                  }}'
            ),
        ]);
        $this->send($handler);
    }

    /**
     * @param $handler
     *
     * @throws \AvtoDev\SmsPilotNotificationsChanel\Exceptions\CouldNotSendNotification
     * @throws \InvalidArgumentException
     */
    private function send($handler)
    {
        $api = new SmsPilotApi('', '', ['handler' => $handler]);
        $api->send('re', '79999999999');
    }
}
