<?php

namespace AvtoDev\SmsPilotNotificationsChanel\Tests\Examples;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class SmsNotificationReceiver extends Model
{
    use Notifiable;

    protected $phone = '79999999999';

    public function __construct($phone = '79999999999', array $attributes = [])
    {
        $this->phone = $phone;
        parent::__construct($attributes);
    }

    public function routeNotificationForSms()
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }
}
