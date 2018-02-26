<?php

namespace AvtoDev\SmsPilotNotifications\ApiClient;

use Exception;
use GuzzleHttp\Client as GuzzleHttpClient;
use AvtoDev\SmsPilotNotifications\Messages\SmsPilotMessage;
use AvtoDev\SmsPilotNotifications\Exceptions\CannotSendMessage;
use AvtoDev\SmsPilotNotifications\Exceptions\HttpRequestException;
use AvtoDev\SmsPilotNotifications\Exceptions\InvalidResponseException;
use AvtoDev\SmsPilotNotifications\ApiClient\Responses\MessageSentResponse;

/**
 * Class SmsPilotApi.
 *
 * SMS Pilot API service.
 */
class ApiClient implements ApiClientInterface
{
    /**
     * API entry-point URI.
     *
     * @var string
     */
    protected $api_uri = 'https://smspilot.ru/api.php';

    /**
     * HTTP client instance.
     *
     * @var GuzzleHttpClient
     */
    protected $http_client;

    /**
     * SMS Pilot API key.
     *
     * @var string
     */
    protected $api_key;

    /**
     * Sender name from list.
     *
     * @see https://smspilot.ru/my-sender.php
     *
     * @var string
     */
    protected $default_sender_name;

    /**
     * SmsPilotApi constructor.
     *
     * @param string $api_key             API key
     * @param string $default_sender_name Default sender name
     */
    public function __construct($api_key, $default_sender_name)
    {
        $this->api_key             = (string) $api_key;
        $this->default_sender_name = (string) $default_sender_name;

        $this->http_client = $this->httpClientFactory();
    }

    /**
     * {@inheritdoc}
     */
    public function send(SmsPilotMessage $message)
    {
        try {
            $response = $this->http_client->request(
                'get',
                $this->api_uri,
                [
                    'query' => [
                        'charset' => 'utf-8',
                        'send'    => $message->content,
                        'to'      => $message->phone_number,
                        'apikey'  => $this->api_key,
                        'from'    => ! empty($message->sender_name) && is_string($message->sender_name)
                            ? $message->sender_name
                            : $this->default_sender_name,
                        'format'  => 'json',
                    ],
                ]
            );
        } catch (Exception $e) {
            throw new HttpRequestException('Cannot complete HTTP request to the SMS Pilot API', $e->getCode(), $e);
        }

        $decoded_response = json_decode((string) $response->getBody(), true);

        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded_response) && ! empty($decoded_response)) {
            if (isset($decoded_response['error'])) {
                $code        = isset($decoded_response['error']['code'])
                    ? (int) $decoded_response['error']['code']
                    : 0;
                $description = isset($decoded_response['error']['description'])
                    ? (string) $decoded_response['error']['description']
                    : 'Unavailable';

                throw new CannotSendMessage(
                    sprintf('Server respond an error: "%s" (code: %s)', $description, $code), $code
                );
            }

            return new MessageSentResponse($response);
        } else {
            throw new InvalidResponseException('We\'v got invalid server response (invalid JSON)');
        }
    }

    /**
     * HTTP Client factory.
     *
     * @param array $http_client_config
     *
     * @return GuzzleHttpClient
     */
    protected function httpClientFactory(array $http_client_config = [])
    {
        return new GuzzleHttpClient(array_replace_recursive([
            'timeout'         => 25,
            'connect_timeout' => 25,
        ], $http_client_config));
    }
}
