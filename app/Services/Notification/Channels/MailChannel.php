<?php

namespace App\Services\Notification\Channels;

use App\Services\Notification\Contracts\NotificationChannel;
use App\Services\Notification\DTO\NotificationData;

class MailChannel implements NotificationChannel
{
    public function send(
        NotificationData $notification
    ): void {

        /*
            Mail::to(...)
        */
    }
}
