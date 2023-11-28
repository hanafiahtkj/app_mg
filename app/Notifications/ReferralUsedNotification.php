<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReferralUsedNotification extends Notification
{
    use Queueable;

    protected $referralUser;

    public function __construct($referralUser)
    {
        $this->referralUser = $referralUser;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => "Someone has registered using your referral code! Referral User: " .$this->referralUser->email,
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'message' => "Someone has registered using your referral code! Referral User: " .$this->referralUser->email,
        ];
    }
}
