<?php

namespace AvtoDev\SmsPilotNotifications\Tests\ApiClient;

use AvtoDev\SmsPilotNotifications\ApiClient\ApiClient;
use AvtoDev\SmsPilotNotifications\Messages\SmsPilotMessage;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

/**
 * Class ApiClientMock.
 *
 * Mocked API client class.
 */
class ApiClientMock extends ApiClient
{
    /**
     * @var mixed[]
     */
    protected $faked_responses = [];

    /**
     * {@inheritdoc}
     *
     * @param mixed[] Faked responses
     */
    public function __construct($api_key, $default_sender_name)
    {
        // Allow 3rd argument (faked responses) supports
        if (func_num_args() > 2) {
            $this->faked_responses = (array) func_get_arg(2);
        }

        parent::__construct($api_key, $default_sender_name);
    }

    /**
     * {@inheritdoc}
     */
    public function send(SmsPilotMessage $message)
    {
        if (empty($this->faked_responses)) {
            $this->faked_responses = [
                new Response(200, [], sprintf('{"send":[
                    {"server_id":"666","phone":"%s","price":"2.26", "status":"0"}
                    ],"balance":"28.00","cost":"2"}', $message->to)
                ),
            ];

            $this->http_client = $this->httpClientFactory();
        }

        return parent::send($message);
    }

    /**
     * {@inheritdoc}
     */
    protected function httpClientFactory(array $http_client_config = [])
    {
        $mock    = new MockHandler($this->faked_responses);
        $handler = HandlerStack::create($mock);

        return parent::httpClientFactory([
            'handler' => $handler,
        ]);
    }
}
