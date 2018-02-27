<?php

namespace AvtoDev\SmsPilotNotifications;

use Illuminate\Foundation\Application;
use AvtoDev\SmsPilotNotifications\ApiClient\ApiClient;
use AvtoDev\SmsPilotNotifications\ApiClient\ApiClientInterface;
use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;

/**
 * Class SmsPilotServiceProvider.
 */
class SmsPilotServiceProvider extends IlluminateServiceProvider
{
    /**
     * Boot any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app
            ->when(SmsPilotChannel::class)
            ->needs(ApiClientInterface::class)
            ->give(function (Application $app) {
                /** @var \Illuminate\Config\Repository $config */
                $config = $app->make('config');

                return new ApiClient(
                    $config->get('services.sms-pilot.key'),
                    $config->get('services.sms-pilot.sender_name')
                );
            });
    }
}
