<?php

namespace App\Services\Notification\DTO;

class NotificationData
{
    public function __construct(

        public string $title,

        public string $message,

        public mixed $recipient,

        public array $data = [],

        public array $channels = [
            'database',
            'mail'
        ]

    ) {}
}
