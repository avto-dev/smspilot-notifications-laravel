<?php

namespace AvtoDev\SmsPilotNotifications\ApiClient\Responses;

use AvtoDev\SmsPilotNotifications\Messages\SentMessage;

/**
 * Class MessageSentResponse.
 */
class MessageSentResponse extends AbstractResponse
{
    /**
     * Convert RAW message data (passed as an array) into object.
     *
     * @param array $message_data
     *
     * @return SentMessage|null
     */
    protected function convertRawMessageInfoIntoObject($message_data)
    {
        $message_data = (array) $message_data;

        if (
            isset($message_data['server_id'])
            && isset($message_data['phone'])
            && isset($message_data['price'])
            && isset($message_data['status'])
        ) {
            return new SentMessage(
                $message_data['server_id'],
                $message_data['phone'],
                $message_data['price'],
                $message_data['status']
            );
        }

        return null;
    }

    /**
     * Returns array of sent messages info.
     *
     * @return SentMessage[]|array
     */
    public function getSentMessages()
    {
        $messages = [];

        foreach ((array) $this->getBody('send') as $raw_message) {
            array_push($messages, $this->convertRawMessageInfoIntoObject($raw_message));
        }

        return array_filter($messages);
    }

    /**
     * Returns account balance.
     *
     * @return float|null
     */
    public function getBalance()
    {
        $balance = $this->getBody('balance');

        return is_numeric($balance)
            ? (float) $balance
            : null;
    }

    /**
     * Returns total cost of sanded messages.
     *
     * @return float|null
     */
    public function getCost()
    {
        $cost = $this->getBody('cost');

        return is_numeric($cost)
            ? (float) $cost
            : null;
    }
}
