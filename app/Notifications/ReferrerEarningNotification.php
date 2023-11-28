<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReferrerEarningNotification extends Notification
{
    protected $amount;
    protected $referralEmail;

    public function __construct($amount, $referralEmail)
    {
        $this->amount = $amount;
        $this->referralEmail = $referralEmail;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => "You have received earning of $this->amount from a referral with email $this->referralEmail!",
        ];
    }

    public function toArray($notifiable)
    {
        return [
            'message' => "You have received earning of $this->amount from a referral with email $this->referralEmail!",
        ];
    }
}
