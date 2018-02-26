<?php

namespace AvtoDev\SmsPilotNotifications;

use Illuminate\Foundation\Application;
use AvtoDev\SmsPilotNotifications\ApiClient\ApiClient;
use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;

/**
 * Class SmsPilotServiceProvider.
 */
class SmsPilotServiceProvider extends IlluminateServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app
            ->when(SmsPilotChannel::class)
            ->needs(ApiClient::class)
            ->give(function (Application $app) {
                /** @var \Illuminate\Config\Repository $config */
                $config = $app->make('config');

                return new ApiClient(
                    $config->get('services.smspilot.key'),
                    $config->get('services.smspilot.sender_name')
                );
            });
    }
}
