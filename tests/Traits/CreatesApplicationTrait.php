<?php

namespace AvtoDev\SmsPilotNotifications\Tests\Traits;

use AvtoDev\SmsPilotNotifications\SmsPilotServiceProvider;
use Illuminate\Contracts\Console\Kernel;

trait CreatesApplicationTrait
{
    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        /** @var \Illuminate\Foundation\Application $app */
        $app = require __DIR__ . '/../../vendor/laravel/laravel/bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();

        /** @var \Illuminate\Config\Repository $config */
        $config = $app->make('config');
        $config->set('services.smspilot', [
            'key'         => env('SMS_PILOT_API_KEY'),
            'sender_name' => env('SMS_PILOT_SENDER_NAME'),
        ]);

        $app->register(SmsPilotServiceProvider::class);

        return $app;
    }
}
