<?php

namespace App\Mail;

use App\Contracts\Notification\NotificationMessageDataClassContract;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public readonly NotificationMessageDataClassContract $messageDataClass
    )
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->messageDataClass->mailerSubject(),
        );
    }

    public function content(): Content
    {
        return new Content(
            view: $this->messageDataClass->mailerTemplate(),
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
