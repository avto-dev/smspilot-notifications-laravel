<?php

declare(strict_types = 1);

namespace AvtoDev\SmsPilotNotifications\Tests\Stubs;

use AvtoDev\SmsPilotNotifications\Messages\SmsPilotMessage;

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
