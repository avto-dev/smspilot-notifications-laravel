<?php

namespace AvtoDev\SmsPilotNotifications\Tests\Stubs;

use AvtoDev\SmsPilotNotifications\Messages\SmsPilotMessage;

/**
 * Class NotificationStub.
 */
class NotificationStub extends Notification
{
    /**
     * @return SmsPilotMessage
     */
    public function toSmsPilot()
    {
        return SmsPilotMessage::create()
            ->from('Devil')
            ->content('Some content');
    }
}
