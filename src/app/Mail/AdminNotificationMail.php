<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;

class AdminNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $subjectLine,
        public string $bodyText
    )
    {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'CINEMA-HOUSE ' . $this->subjectLine,
            from: new Address(
                env('MAIL_FROM_ADDRESS', 'hello@example.com'), 
                env('MAIL_FROM_NAME', 'Example'),
            ),
        );
    }

    /**
     * メール本文
     */
    public function content(): Content
    {
        return new Content(
            view: 'mail.AdminNotification',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
