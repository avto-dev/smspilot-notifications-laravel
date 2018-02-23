<?php

namespace AvtoDev\SmsPilotNotificationsChanel;

use AvtoDev\SmsPilotNotificationsChanel\ApiClient\SmsPilotApi;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;

/**
 * Class SmsPilotNotificationsServiceProvider.
 */
class SmsPilotNotificationsServiceProvider extends IlluminateServiceProvider
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
        $this->initializeConfigs();

        $this->app->singleton(SmsPilotApi::class, function (Application $app) {
            /** @var \Illuminate\Config\Repository $config */
            $config = $app->make('config');

            return new SmsPilotApi(
                $config->get('sms_pilot.api_key'),
                $config->get('sms_pilot.sender'),
                $config->get('sms_pilot')
            );
        });
    }

    /**
     * Returns config path.
     *
     * @return string
     */
    public static function getConfigPath()
    {
        return __DIR__ . '/config/sms-pilot.php';
    }

    /**
     * Get config root key name.
     *
     * @return string
     */
    public static function getConfigRootKeyName()
    {
        return basename(static::getConfigPath(), '.php');
    }

    /**
     * Initialize configs.
     *
     * @return void
     */
    protected function initializeConfigs()
    {
        $this->mergeConfigFrom(static::getConfigPath(), static::getConfigRootKeyName());

        $this->publishes([
            realpath(static::getConfigPath()) => config_path(basename(static::getConfigPath())),
        ], 'config');
    }
}
