<?php

namespace AvtoDev\SmsPilotNotificationsChanel\ApiClient;

use Exception;
use GuzzleHttp\Client as GuzzleHttpClient;
use AvtoDev\SmsPilotNotificationsChanel\SmsPilotHttpResponse;
use AvtoDev\SmsPilotNotificationsChanel\Exceptions\CannotSendMessage;
use AvtoDev\SmsPilotNotificationsChanel\Exceptions\HttpRequestException;
use AvtoDev\SmsPilotNotificationsChanel\Exceptions\InvalidResponseException;

/**
 * Class SmsPilotApi.
 *
 * SMS Pilot API service.
 */
class SmsPilotApi implements SMSPilotApiInterface
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
    protected $sender_name;

    /**
     * SmsPilotApi constructor.
     *
     * @param string $api_key            API key
     * @param string $sender_name        Sender name
     * @param array  $http_client_config Additional HTTP client settings
     */
    public function __construct($api_key, $sender_name, $http_client_config = [])
    {
        $this->api_key     = (string) $api_key;
        $this->sender_name = (string) $sender_name;

        $this->http_client = $this->httpClientFactory((array) $http_client_config);
    }

    /**
     * {@inheritdoc}
     */
    public function send($text, $recipient, array $params = [])
    {
        $base = [
            'charset' => 'utf-8',
            'send'    => $text,
            'to'      => $recipient,
            'apikey'  => $this->api_key,
            'from'    => $this->sender_name,
            'format'  => 'json',
        ];

        try {
            $response = $this->http_client->request(
                'get',
                $this->api_uri,
                ['query' => array_replace_recursive($base, $params)]
            );
        } catch (Exception $e) {
            throw new HttpRequestException('Cannot complete HTTP request to the SMS Pilot API service', 0, $e);
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

            return new SmsPilotHttpResponse($response);
        } else {
            throw new InvalidResponseException('Ve\'v got invalid server response (invalid JSON)');
        }
    }

    /**
     * HTTP Client factory.
     *
     * @param array $http_client_config
     *
     * @return GuzzleHttpClient
     */
    protected function httpClientFactory($http_client_config = [])
    {
        return new GuzzleHttpClient(array_replace_recursive([
            'timeout'         => 5,
            'connect_timeout' => 5,
        ], $http_client_config));
    }
}
