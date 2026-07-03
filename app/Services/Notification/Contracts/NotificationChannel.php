<?php

namespace App\Services\Notification\Contracts;

use App\Services\Notification\DTO\NotificationData;

interface NotificationChannel
{
    public function send(
        NotificationData $notification
    ): void;
}
