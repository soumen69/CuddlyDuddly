<?php

namespace App\Services\Notification;

use App\Services\Notification\Channels\DatabaseChannel;
use App\Services\Notification\Channels\MailChannel;
use App\Services\Notification\Channels\SmsChannel;
use App\Services\Notification\Channels\WhatsappChannel;
use App\Services\Notification\DTO\NotificationData;

class NotificationManager
{
    public function __construct(

        protected DatabaseChannel $database,

        protected MailChannel $mail,

        protected SmsChannel $sms,

        protected WhatsappChannel $whatsapp

    ) {}

    public function send(
        NotificationData $notification
    ): void {

        foreach (
            $notification->channels
            as $channel
        ) {

            match ($channel) {

                'database'
                => $this->database->send(
                    $notification
                ),

                'mail'
                => $this->mail->send(
                    $notification
                ),

                'sms'
                => $this->sms->send(
                    $notification
                ),

                'whatsapp'
                => $this->whatsapp->send(
                    $notification
                ),

                default => null,
            };
        }
    }
}
