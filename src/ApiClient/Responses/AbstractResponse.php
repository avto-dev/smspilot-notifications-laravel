<?php

namespace AvtoDev\SmsPilotNotifications\ApiClient\Responses;

use Illuminate\Support\Arr;
use Psr\Http\Message\ResponseInterface;
use AvtoDev\SmsPilotNotifications\Exceptions\InvalidResponseException;

abstract class AbstractResponse
{
    /**
     * @var ResponseInterface
     */
    protected $http_response;

    /**
     * Decoded response body.
     *
     * @var array
     */
    protected $decoded_body;

    /**
     * AbstractApiClientResponse constructor.
     *
     * @param ResponseInterface $http_response
     */
    public function __construct(ResponseInterface $http_response)
    {
        $this->http_response = $http_response;
        $this->decoded_body  = $this->decodeResponseBody($http_response);
    }

    /**
     * Get base response object.
     *
     * @return ResponseInterface
     */
    public function getHttpResponse()
    {
        return $this->http_response;
    }

    /**
     * Returns decoded body content as-is, if key value is not passed.
     *
     * Otherwise (if key passed) - returns an item from body content using "dot" notation.
     *
     * @param string|null $key
     * @param mixed|null  $default
     *
     * @return array|mixed
     */
    public function getBody($key = null, $default = null)
    {
        return $key === null
            ? $this->decoded_body
            : Arr::get($this->decoded_body, $key, $default);
    }

    /**
     * Read response body as a json string, and decode it to the array.
     *
     * @param ResponseInterface $http_response
     *
     * @throws InvalidResponseException
     *
     * @return array
     */
    protected function decodeResponseBody(ResponseInterface $http_response)
    {
        $decoded = \json_decode($http_response->getBody(), true);

        if (\is_array($decoded) && \json_last_error() === JSON_ERROR_NONE) {
            return $decoded;
        }

        throw new InvalidResponseException('Cannot decode response body (probably wrong JSON structure)');
    }
}
