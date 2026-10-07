<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;

/**
 * A simple in-app notification: a message plus the page it should open.
 */
class AppNotification extends Notification
{
    public function __construct(public string $message, public string $url)
    {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'message' => $this->message,
            'url' => $this->url,
        ];
    }
}
