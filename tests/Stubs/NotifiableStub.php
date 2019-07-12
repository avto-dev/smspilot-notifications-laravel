<?php

declare(strict_types = 1);

namespace AvtoDev\SmsPilotNotifications\Tests\Stubs;

class NotifiableStub extends Notifiable
{
    /**
     * @return string
     */
    public function routeNotificationForSmsPilot(): string
    {
        return '71112223344';
    }
}
