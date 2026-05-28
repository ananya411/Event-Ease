<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class BookingNotification extends Notification
{
    use Queueable;

    private $message;

    public function __construct($message)
    {
        $this->message = $message;
    }

    /*
    |--------------------------------------------------------------------------
    | Delivery Channels
    |--------------------------------------------------------------------------
    */

    public function via($notifiable)
    {
        return ['database'];
    }

    /*
    |--------------------------------------------------------------------------
    | Database Format
    |--------------------------------------------------------------------------
    */

    public function toDatabase($notifiable)
    {
        return [
            'message' => $this->message,
            'time' => now(),
        ];
    }
}