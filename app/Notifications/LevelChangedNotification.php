<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LevelChangedNotification extends Notification
{
    protected $newLevel;

    public function __construct($newLevel)
    {
        $this->newLevel = $newLevel;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => 'Your level has been changed to ' . $this->newLevel,
        ];
    }

    public function toArray($notifiable)
    {
        return [
            'message' => 'Your level has been changed to ' . $this->newLevel,
        ];
    }
}
