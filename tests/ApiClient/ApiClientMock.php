<?php

namespace AvtoDev\SmsPilotNotifications\Tests\ApiClient;

use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\MockHandler;
use AvtoDev\SmsPilotNotifications\ApiClient\ApiClient;

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
        if (func_num_args() >= 2) {
            $this->faked_responses = (array) func_get_arg(2);
        }

        parent::__construct($api_key, $default_sender_name);
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
