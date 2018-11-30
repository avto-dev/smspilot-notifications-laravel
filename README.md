<p align="center">
  <img src="https://laravel.com/assets/img/components/logo-laravel.svg" alt="Laravel" width="240" />
</p>

# Канал уведомлений для сервиса "SMS Pilot"

[![Version][badge_packagist_version]][link_packagist]
[![Version][badge_php_version]][link_packagist]
[![Build Status][badge_build_status]][link_build_status]
[![Coverage][badge_coverage]][link_coverage]
[![Code quality][badge_code_quality]][link_code_quality]
[![Downloads count][badge_downloads_count]][link_packagist]
[![License][badge_license]][link_license]

Используя данный канал для уведомлений вы сможете легко интегрировать SMS уведомления в ваше Laravel-приложение, для отправки которых используется сервис "[SMS Pilot][smspilot_home]".

## Установка

Для установки данного пакета выполните в терминале следующую команду:

```shell
$ composer require avto-dev/smspilot-notifications-laravel "^1.0.2"
```

> Для этого необходим установленный `composer`. Для его установки перейдите по [данной ссылке][getcomposer].

> Обратите внимание на то, что необходимо фиксировать мажорную версию устанавливаемого пакета.

Если вы используете Laravel версии 5.5 и выше, то сервис-провайдер данного пакета будет зарегистрирован автоматически. В противном случае вам необходимо самостоятельно зарегистрировать сервис-провайдер в секции `providers` файла `./config/app.php`:

```php
'providers' => [
    // ...
    AvtoDev\SmsPilotNotifications\SmsPilotServiceProvider::class,
]
```

## Настройка

После установки вам необходимо изменить файл `./config/services.php`, добавив в него следующие строки:

```php
return [
 
    // ...
    
    'sms-pilot' => [
        'key'         => env('SMS_PILOT_API_KEY'),
        'sender_name' => env('SMS_PILOT_SENDER_NAME'),
    ],
 
];
```

И добавить в файл `./.env`:

```ini
SMS_PILOT_API_KEY=%your_api_key%
SMS_PILOT_SENDER_NAME=%your_sender_name%
```

Где `SMS_PILOT_API_KEY` - это ключ (токен) авторизации на сервисе SMS Pilot (получить его вы можете [на данной странице][smspilot_get_api_key]), а `SMS_PILOT_SENDER_NAME` - это имя отправителя, которое установлено в [панели управления][smspilot_sender_names] (будет использоваться как имя отправителя по умолчанию).

## Использование

> Ознакомиться с тем, как работают нотификации в Laravel-приложениях вы можете [по этой ссылке][laravel_notifications].

Базовый пример отправки уведомления может выглядеть следующим образом:

```php
use AvtoDev\SmsPilotNotifications\SmsPilotChannel;
use AvtoDev\SmsPilotNotifications\Messages\SmsPilotMessage;

/**
 * Notification object.
 */
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
    public function toSmsPilot($notifiable)
    {
        return SmsPilotMessage::create()
            ->content('Some SMS notification message');
    }
}
```

Доступные к использованию методы у объекта `SmsPilotMessage`:

Имя метода  | Описание
----------- | --------
`from()`    | Имя отправителя из [списка][smspilot_sender_names] (опционально)
`to()`      | Номер телефона получателя (опционально, имеет более высокий приоритет чем `routeNotificationForSmsPilot`)
`content()` | Текст сообщения

Пример нотифицируемого объекта:

```php
/**
 * Notifiable object.
 */
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
    public function routeNotificationForSmsPilot($notifiable)
    {
        return '71112223344';
    }
}
```

### Testing

For package testing we use `phpunit` framework. Just write into your terminal:

```shell
$ git clone git@github.com:avto-dev/smspilot-notifications-laravel.git ./smspilot-notifications-laravel && cd $_
$ composer install
$ composer test
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
[badge_build_status]:https://travis-ci.org/avto-dev/smspilot-notifications-laravel.svg?branch=master
[badge_code_quality]:https://img.shields.io/scrutinizer/g/avto-dev/smspilot-notifications-laravel.svg?maxAge=180
[badge_coverage]:https://img.shields.io/codecov/c/github/avto-dev/smspilot-notifications-laravel/master.svg?maxAge=60
[badge_downloads_count]:https://img.shields.io/packagist/dt/avto-dev/smspilot-notifications-laravel.svg?maxAge=180
[badge_license]:https://img.shields.io/packagist/l/avto-dev/smspilot-notifications-laravel.svg?longCache=true
[badge_release_date]:https://img.shields.io/github/release-date/avto-dev/smspilot-notifications-laravel.svg?style=flat-square&maxAge=180
[badge_commits_since_release]:https://img.shields.io/github/commits-since/avto-dev/smspilot-notifications-laravel/latest.svg?style=flat-square&maxAge=180
[badge_issues]:https://img.shields.io/github/issues/avto-dev/smspilot-notifications-laravel.svg?style=flat-square&maxAge=180
[badge_pulls]:https://img.shields.io/github/issues-pr/avto-dev/smspilot-notifications-laravel.svg?style=flat-square&maxAge=180
[link_releases]:https://github.com/avto-dev/smspilot-notifications-laravel/releases
[link_packagist]:https://packagist.org/packages/avto-dev/smspilot-notifications-laravel
[link_build_status]:https://travis-ci.org/avto-dev/smspilot-notifications-laravel
[link_coverage]:https://codecov.io/gh/avto-dev/smspilot-notifications-laravel/
[link_changes_log]:https://github.com/avto-dev/smspilot-notifications-laravel/blob/master/CHANGELOG.md
[link_code_quality]:https://scrutinizer-ci.com/g/avto-dev/smspilot-notifications-laravel/
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
