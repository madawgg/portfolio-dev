<?php

namespace App\Mail;

use App\Models\ContactMessage;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;

class ContactMessageReceived extends Mailable
{
    public function __construct(
        public ContactMessage $contactMessage,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Has recibido un correo en el portfolio',
            replyTo: [new Address($this->contactMessage->sender_email)],
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.contact-received',
        );
    }
}
