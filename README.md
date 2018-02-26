<p align="center">
  <img src="https://laravel.com/assets/img/components/logo-laravel.svg" alt="Laravel" width="240" />
</p>

# Канал уведомлений для сервиса "SMS Pilot"

[![Version][badge_version]][link_packagist]
[![Build Status][badge_build_status]][link_build_status]
[![StyleCI][badge_styleci]][link_styleci]
[![Coverage][badge_coverage]][link_coverage]
[![Code Quality][badge_quality]][link_coverage]
[![Issues][badge_issues]][link_issues]
[![License][badge_license]][link_license]
[![Downloads count][badge_downloads_count]][link_packagist]

Используя данный канал для уведомлений вы сможете легко интегрировать SMS уведомления в ваше Laravel-приложение, для отправки которых используется сервис "[SMS Pilot][smspilot_home]".

## Установка

Для установки данного пакета выполните в терминале следующую команду:

```shell
$ composer require avto-dev/smspilot-notifications-laravel "^1.0"
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

### Тестирование

Для тестирования данного пакета используется фреймворк `phpunit`. Для запуска тестов выполните в терминале:

```shell
$ git clone git@github.com:avto-dev/smspilot-notifications-laravel.git ./smspilot-notifications-laravel && cd $_
$ composer update
$ composer test
```

## Поддержка и развитие

Если у вас возникли какие-либо проблемы по работе с данным пакетом, пожалуйста, создайте соответствующий `issue` в данном репозитории.

Если вы способны самостоятельно реализовать тот функционал, что вам необходим - создайте PR с соответствующими изменениями. Крайне желательно сопровождать PR соответствующими тестами, фиксирующими работу ваших изменений. После проверки и принятия изменений будет опубликована новая минорная версия.

## Лицензирование

Код данного пакета распространяется под лицензией [MIT][link_license].

[badge_version]:https://img.shields.io/packagist/v/avto-dev/smspilot-notifications-laravel.svg?style=flat&maxAge=30
[badge_downloads_count]:https://img.shields.io/packagist/dt/avto-dev/smspilot-notifications-laravel.svg?style=flat&maxAge=30
[badge_license]:https://img.shields.io/packagist/l/avto-dev/smspilot-notifications-laravel.svg?style=flat&maxAge=30
[badge_build_status]:https://scrutinizer-ci.com/g/avto-dev/smspilot-notifications-laravel/badges/build.png?b=master
[badge_styleci]:https://styleci.io/repos/122658447/shield
[badge_coverage]:https://scrutinizer-ci.com/g/avto-dev/smspilot-notifications-laravel/badges/coverage.png?b=master
[badge_quality]:https://scrutinizer-ci.com/g/avto-dev/smspilot-notifications-laravel/badges/quality-score.png?b=master
[badge_issues]:https://img.shields.io/github/issues/avto-dev/smspilot-notifications-laravel.svg?style=flat&maxAge=30
[link_packagist]:https://packagist.org/packages/avto-dev/smspilot-notifications-laravel
[link_styleci]:https://styleci.io/repos/122658447/
[link_license]:https://github.com/avto-dev/smspilot-notifications-laravel/blob/master/LICENSE
[link_build_status]:https://scrutinizer-ci.com/g/avto-dev/smspilot-notifications-laravel/build-status/master
[link_coverage]:https://scrutinizer-ci.com/g/avto-dev/smspilot-notifications-laravel/?branch=master
[link_issues]:https://github.com/avto-dev/smspilot-notifications-laravel/issues
[smspilot_home]:https://smspilot.ru/
[smspilot_get_api_key]:https://smspilot.ru/my-settings.php#api
[smspilot_sender_names]:https://smspilot.ru/my-sender.php
[laravel_notifications]:https://laravel.com/docs/5.5/notifications
[getcomposer]:https://getcomposer.org/download/
