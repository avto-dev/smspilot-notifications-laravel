<?php

namespace AvtoDev\SmsPilotNotifications\Tests\Stubs;

/**
 * Class NotifiableStub.
 */
class NotifiableStub extends Notifiable
{
    /**
     * @return string
     */
    public function routeNotificationForSmsPilot()
    {
        return '71112223344';
    }
}
