<?php

namespace App\Mail;

use App\Models\Guest;
use App\Models\Event;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class GuestInvitation extends Mailable
{
    use Queueable, SerializesModels;

    public Guest $guest;
    public Event $event;
    public string $rsvpUrl;

    public function __construct(Guest $guest, Event $event)
    {
        $this->guest   = $guest;
        $this->event   = $event;
        $this->rsvpUrl = url('/rsvp/' . $guest->rsvp_token);
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '🎉 You\'re Invited — ' . $this->event->title,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.guest-invitation',
        );
    }
}
