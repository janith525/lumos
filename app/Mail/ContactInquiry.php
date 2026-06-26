<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactInquiry extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public string $name,
        public string $email,
        public ?string $phone,
        public string $subjectText,
        public string $messageText
    ) {}

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Lumos Contact Inquiry: ' . $this->subjectText,
            replyTo: [
                new Address($this->email, $this->name),
            ],
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            htmlString: '<p><strong>Name:</strong> '.e($this->name).'</p>'
                .'<p><strong>Email:</strong> '.e($this->email).'</p>'
                .'<p><strong>Phone:</strong> '.e($this->phone ?? '—').'</p>'
                .'<p><strong>Subject:</strong> '.e($this->subjectText).'</p>'
                .'<p><strong>Message:</strong></p>'
                .'<p>'.nl2br(e($this->messageText)).'</p>',
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
