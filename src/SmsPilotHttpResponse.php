<?php

namespace AvtoDev\SmsPilotNotificationsChanel;

use AvtoDev\SmsPilotNotificationsChanel\Messages\SentMessage;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;

/**
 * Class SmsPilotHttpResponse.
 *
 * Custom response with helpers
 */
class SmsPilotHttpResponse extends Response
{
    /**
     * @var array decoded body
     */
    protected $decoded_body;

    /**
     * SmsPilotHttpResponse constructor.
     *
     * @param ResponseInterface $response
     */
    public function __construct(ResponseInterface $response)
    {
        parent::__construct(
            $response->getStatusCode(),
            $response->getHeaders(),
            $response->getBody(),
            $response->getProtocolVersion(),
            $response->getReasonPhrase()
        );
    }

    /**
     * Returns array of sanded messages info.
     *
     * @return array|SentMessage[]
     */
    public function getSandedMessages()
    {
        $messages = [];
        foreach (array_get($this->getDecodedBody(), 'send', []) as $send) {
            $messages[] = new SentMessage(
                $send['server_id'],
                $send['phone'],
                $send['price'],
                $send['status']
            );
        }

        return $messages;
    }

    /**
     * Returns account balance.
     *
     * @return float
     */
    public function getBalance()
    {
        return (float) $this->getDecodedBody()['balance'];
    }

    /**
     * Returns total cost of sanded messages.
     *
     * @return float
     */
    public function getCost()
    {
        return (float) $this->getDecodedBody()['cost'];
    }

    /**
     * Returns json decoded response body.
     *
     * @param array ...$argc additional arguments for json_decode
     *
     * @return array|mixed
     */
    protected function getDecodedBody(...$argc)
    {
        $this->decoded_body = json_decode((string) $this->getBody(), true, ...$argc);

        return $this->decoded_body;
    }
}
