<?php

declare(strict_types = 1);

namespace AvtoDev\SmsPilotNotifications\ApiClient;

use Exception;
use GuzzleHttp\RequestOptions;
use GuzzleHttp\Client as GuzzleHttpClient;
use AvtoDev\SmsPilotNotifications\Messages\SmsPilotMessage;
use AvtoDev\SmsPilotNotifications\Exceptions\CannotSendMessage;
use AvtoDev\SmsPilotNotifications\Exceptions\HttpRequestException;
use AvtoDev\SmsPilotNotifications\Exceptions\InvalidResponseException;
use AvtoDev\SmsPilotNotifications\ApiClient\Responses\MessageSentResponse;

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
     * {@inheritdoc}
     */
    public function __construct(string $api_key, string $default_sender_name)
    {
        $this->api_key             = $api_key;
        $this->default_sender_name = $default_sender_name;

        $this->http_client = $this->httpClientFactory();
    }

    /**
     * {@inheritdoc}
     */
    public function send(SmsPilotMessage $message): MessageSentResponse
    {
        try {
            $response = $this->http_client->request(
                'get',
                $this->api_uri,
                [
                    'query' => [
                        'charset' => 'utf-8',
                        'send'    => $message->content,
                        'to'      => $message->to,
                        'apikey'  => $this->api_key,
                        'from'    => \is_string($message->from)
                            ? $message->from
                            : $this->default_sender_name,
                        'format'  => 'json',
                    ],
                ]
            );
        } catch (Exception $e) {
            throw new HttpRequestException('Cannot complete HTTP request to the SMS Pilot API', $e->getCode(), $e);
        }

        $data = \json_decode((string) $response->getBody(), true);

        if (\is_array($data) && ! empty($data) && \json_last_error() === JSON_ERROR_NONE) {
            if (isset($data['error'])) {
                $code        = isset($data['error']['code']) && \is_numeric($code = $data['error']['code'])
                    ? (int) $code
                    : 0;
                $description = isset($data['error']['description']) && \is_string($desc = $data['error']['description'])
                    ? $desc
                    : 'Error description unavailable';

                throw new CannotSendMessage(
                    \sprintf('Server respond an error: "%s" (code: %d)', $description, $code), $code
                );
            }

            return new MessageSentResponse($response);
        }

        throw new InvalidResponseException('We\'v got invalid server response (invalid JSON)');
    }

    /**
     * HTTP Client factory.
     *
     * @param array $http_client_config
     *
     * @return GuzzleHttpClient
     */
    protected function httpClientFactory(array $http_client_config = []): GuzzleHttpClient
    {
        return new GuzzleHttpClient((array) \array_replace([
            RequestOptions::TIMEOUT         => 25,
            RequestOptions::CONNECT_TIMEOUT => 25,
        ], $http_client_config));
    }
}
