<?php

declare(strict_types = 1);

namespace AvtoDev\SmsPilotNotifications;

use Illuminate\Contracts\Container\Container;
use AvtoDev\SmsPilotNotifications\ApiClient\ApiClient;
use AvtoDev\SmsPilotNotifications\ApiClient\ApiClientInterface;
use Illuminate\Contracts\Config\Repository as ConfigRepository;
use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;

class SmsPilotServiceProvider extends IlluminateServiceProvider
{
    /**
     * Register package services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app
            ->when(SmsPilotChannel::class)
            ->needs(ApiClientInterface::class)
            ->give(function (Container $app) {
                /** @var ConfigRepository $config */
                $config = $app->make(ConfigRepository::class);

                return new ApiClient(
                    $config->get('services.sms-pilot.key'),
                    $config->get('services.sms-pilot.sender_name')
                );
            });
    }
}
