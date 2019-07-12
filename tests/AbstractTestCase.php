<?php

declare(strict_types = 1);

namespace AvtoDev\SmsPilotNotifications\Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class AbstractTestCase extends BaseTestCase
{
    use Traits\CreatesApplicationTrait,
        Traits\AdditionalAssertsTrait;
}
