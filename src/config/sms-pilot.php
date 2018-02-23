<?php

return [

    /*
     | --------------------------------------------------------------------------
     | SMS Pilot service API key
     | --------------------------------------------------------------------------
     |
     | Set here your own API key value.
     |
     | Look here: <https://smspilot.ru/my-settings.php#api>
     */
    'api_key'            => env('SMS_PILOT_API_KEY'),

    /*
     | --------------------------------------------------------------------------
     | Sender name
     | --------------------------------------------------------------------------
     |
     | Sender name must exists in senders names.
     |
     | Look here: <https://smspilot.ru/my-sender.php>
     */
    'sender'             => env('SMS_PILOT_SENDER'),

    /*
     | --------------------------------------------------------------------------
     | HTTP client requests settings
     | --------------------------------------------------------------------------
     |
     | Any additional HTTP client (Guzzle) requests settings.
     |
     | Documentation: <http://docs.guzzlephp.org/en/stable/request-options.html>
     */
    'http_client_config' => [],

];
