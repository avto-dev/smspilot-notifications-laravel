<p align="center">
  <img src="https://laravel.com/assets/img/components/logo-laravel.svg" alt="Laravel" width="240" />
</p>

> Here's the latest documentation on Laravel Notifications System: https://laravel.com/docs/master/notifications

# SMS Pilot notifications channel <sub><sup>| For laravel</sup></sub>

[![Version][badge_packagist_version]][link_packagist]
[![PHP Version][badge_php_version]][link_packagist]
[![Build Status][badge_build_status]][link_build_status]
[![Coverage][badge_coverage]][link_coverage]
[![Downloads count][badge_downloads_count]][link_packagist]
[![License][badge_license]][link_license]

This package makes it easy to send notifications using [SMS Pilot][smspilot_home] with Laravel 5.

## Installation

Require this package with composer using the following command:

```bash
$ composer require avto-dev/smspilot-notifications-laravel "^2.0"
```

> Installed `composer` is required ([how to install composer][getcomposer]).

> You need to fix the major version of package.

Laravel 5.5 and above uses Package Auto-Discovery, so doesn't require you to manually register the service-provider. Otherwise you must add the service provider to the `providers` array in `./config/app.php`:

```php
'providers' => [
    // ...
    AvtoDev\SmsPilotNotifications\SmsPilotServiceProvider::class,
],
```

If you wants to disable package service-provider auto discover, just add into your `composer.json` next lines:

```json
{
    "extra": {
        "laravel": {
            "dont-discover": [
                "avto-dev/smspilot-notifications-laravel"
            ]
        }
    }
}
```

## Setting up the SMS Pilot service

You need to set up SMS Pilot channel in config file `./config/services.php`:

```php
<?php

return [

    // ...

    'sms-pilot' => [
        'key'         => env('SMS_PILOT_API_KEY'),
        'sender_name' => env('SMS_PILOT_SENDER_NAME'),
    ],

];
```

And add into `./.env` file next lines:

```ini
SMS_PILOT_API_KEY=%your_api_key%
SMS_PILOT_SENDER_NAME=%your_sender_name%
```

Where `SMS_PILOT_API_KEY` is SMS Pilot authorization key (token) (try to get it on [this page][smspilot_get_api_key]), `SMS_PILOT_SENDER_NAME` - is sender name, which set in [service dashboard][smspilot_sender_names] _(will be used as sender name by default)_.

## Usage

Now you can use the channel in your `via()` method inside the notification as well as send a push notification:

```php
<?php

use AvtoDev\SmsPilotNotifications\SmsPilotChannel;
use AvtoDev\SmsPilotNotifications\Messages\SmsPilotMessage;

class Notification extends \Illuminate\Notifications\Notification
{
    /**
     * Get the notification channels.
     *
     * @param mixed $notifiable
     *
     * @return array|string
     */
    public function via($notifiable)
    {
        return [SmsPilotChannel::class];
    }

    /**
     * Get the SMS Pilot Message representation of the notification.
     *
     * @param mixed $notifiable
     *
     * @return SmsPilotMessage
     */
    public function toSmsPilot($notifiable): SmsPilotMessage
    {
        return (new SmsPilotMessage)
            ->content('Some SMS notification message');
    }
}
```


```php
<?php

class Notifiable
{
    use \Illuminate\Notifications\Notifiable;

    /**
     * Get route for 'SMS Pilot' notification.
     *
     * @param mixed $notifiable
     *
     * @return string
     */
    public function routeNotificationForSmsPilot($notifiable): string
    {
        return '71112223344';
    }
}
```

### Testing

For package testing we use `phpunit` framework and `docker-ce` + `docker-compose` as develop environment. So, just write into your terminal after repository cloning:

```shell
$ make build
$ make latest # or 'make lowest'
$ make test
```

## Changes log

[![Release date][badge_release_date]][link_releases]
[![Commits since latest release][badge_commits_since_release]][link_commits]

Changes log can be [found here][link_changes_log].

## Support

[![Issues][badge_issues]][link_issues]
[![Issues][badge_pulls]][link_pulls]

If you will find any package errors, please, [make an issue][link_create_issue] in current repository.

## License

This is open-sourced software licensed under the [MIT License][link_license].

[badge_packagist_version]:https://img.shields.io/packagist/v/avto-dev/smspilot-notifications-laravel.svg?maxAge=180
[badge_php_version]:https://img.shields.io/packagist/php-v/avto-dev/smspilot-notifications-laravel.svg?longCache=true
[badge_build_status]:https://img.shields.io/github/actions/workflow/status/avto-dev/smspilot-notifications-laravel/tests.yml
[badge_coverage]:https://img.shields.io/codecov/c/github/avto-dev/smspilot-notifications-laravel/master.svg?maxAge=60
[badge_downloads_count]:https://img.shields.io/packagist/dt/avto-dev/smspilot-notifications-laravel.svg?maxAge=180
[badge_license]:https://img.shields.io/packagist/l/avto-dev/smspilot-notifications-laravel.svg?longCache=true
[badge_release_date]:https://img.shields.io/github/release-date/avto-dev/smspilot-notifications-laravel.svg?style=flat-square&maxAge=180
[badge_commits_since_release]:https://img.shields.io/github/commits-since/avto-dev/smspilot-notifications-laravel/latest.svg?style=flat-square&maxAge=180
[badge_issues]:https://img.shields.io/github/issues/avto-dev/smspilot-notifications-laravel.svg?style=flat-square&maxAge=180
[badge_pulls]:https://img.shields.io/github/issues-pr/avto-dev/smspilot-notifications-laravel.svg?style=flat-square&maxAge=180
[link_releases]:https://github.com/avto-dev/smspilot-notifications-laravel/releases
[link_packagist]:https://packagist.org/packages/avto-dev/smspilot-notifications-laravel
[link_build_status]:https://github.com/avto-dev/smspilot-notifications-laravel/actions
[link_coverage]:https://codecov.io/gh/avto-dev/smspilot-notifications-laravel/
[link_changes_log]:https://github.com/avto-dev/smspilot-notifications-laravel/blob/master/CHANGELOG.md
[link_issues]:https://github.com/avto-dev/smspilot-notifications-laravel/issues
[link_create_issue]:https://github.com/avto-dev/smspilot-notifications-laravel/issues/new/choose
[link_commits]:https://github.com/avto-dev/smspilot-notifications-laravel/commits
[link_pulls]:https://github.com/avto-dev/smspilot-notifications-laravel/pulls
[link_license]:https://github.com/avto-dev/smspilot-notifications-laravel/blob/master/LICENSE
[smspilot_home]:https://smspilot.ru/
[smspilot_get_api_key]:https://smspilot.ru/my-settings.php#api
[smspilot_sender_names]:https://smspilot.ru/my-sender.php
[laravel_notifications]:https://laravel.com/docs/5.5/notifications
[getcomposer]:https://getcomposer.org/download/
