<?php

declare(strict_types = 1);

namespace AvtoDev\SmsPilotNotifications\ApiClient\Responses;

use AvtoDev\SmsPilotNotifications\Messages\SmsPilotSentMessage;

class MessageSentResponse extends AbstractResponse
{
    /**
     * Returns array of sent messages info.
     *
     * @return SmsPilotSentMessage[]|array
     */
    public function getSentMessages(): array
    {
        $messages = [];

        foreach ((array) $this->getBody('send') as $raw_message) {
            $messages[] = $this->convertRawMessageInfoIntoObject((array) $raw_message);
        }

        return \array_filter($messages);
    }

    /**
     * Returns account balance.
     *
     * @return float|null
     */
    public function getBalance(): ?float
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
    public function getCost(): ?float
    {
        $cost = $this->getBody('cost');

        return \is_numeric($cost)
            ? (float) $cost
            : null;
    }

    /**
     * Convert RAW message data (passed as an array) into object.
     *
     * @param array<mixed> $message_data
     *
     * @return SmsPilotSentMessage|null
     */
    protected function convertRawMessageInfoIntoObject(array $message_data): ?SmsPilotSentMessage
    {
        if (
            isset($message_data['server_id'], $message_data['phone'], $message_data['price'], $message_data['status'])
        ) {
            /** @var string $phone */
            $phone = $message_data['phone'];

            return new SmsPilotSentMessage(
                (int) $message_data['server_id'],
                $phone,
                (float) $message_data['price'],
                (int) $message_data['status']
            );
        }

        return null;
    }
}
