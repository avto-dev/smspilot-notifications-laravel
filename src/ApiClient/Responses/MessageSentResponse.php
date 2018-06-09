<?php

namespace AvtoDev\SmsPilotNotifications\ApiClient\Responses;

use AvtoDev\SmsPilotNotifications\Messages\SmsPilotSentMessage;

/**
 * Class MessageSentResponse.
 */
class MessageSentResponse extends AbstractResponse
{
    /**
     * Returns array of sent messages info.
     *
     * @return SmsPilotSentMessage[]|array
     */
    public function getSentMessages()
    {
        $messages = [];

        foreach ((array) $this->getBody('send') as $raw_message) {
            $messages[] = $this->convertRawMessageInfoIntoObject($raw_message);
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

        return \is_numeric($balance)
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

        return \is_numeric($cost)
            ? (float) $cost
            : null;
    }

    /**
     * Convert RAW message data (passed as an array) into object.
     *
     * @param array $message_data
     *
     * @return SmsPilotSentMessage|null
     */
    protected function convertRawMessageInfoIntoObject($message_data)
    {
        $message_data = (array) $message_data;

        if (
            isset($message_data['server_id'], $message_data['phone'], $message_data['price'], $message_data['status'])
        ) {
            return new SmsPilotSentMessage(
                $message_data['server_id'],
                $message_data['phone'],
                $message_data['price'],
                $message_data['status']
            );
        }
    }
}
