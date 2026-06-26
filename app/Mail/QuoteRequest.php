<?php

namespace App\Mail;

use App\Models\Quote;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class QuoteRequest extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Quote $quote) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Lumos Quote/Inquiry from ' . $this->quote->name,
            replyTo: [
                new \Illuminate\Mail\Mailables\Address($this->quote->email, $this->quote->name),
            ],
        );
    }

    public function content(): Content
    {
        return new Content(
            htmlString: '<p><strong>Name:</strong> '.e($this->quote->name).'</p>'
                .'<p><strong>Email:</strong> '.e($this->quote->email).'</p>'
                .'<p><strong>Phone:</strong> '.e($this->quote->phone ?? '—').'</p>'
                .'<p><strong>Message:</strong> '.e($this->quote->message ?? '—').'</p>'
                .'<p><strong>Products/Services:</strong> '.e(json_encode($this->quote->products ?? [])).'</p>',
        );
    }

    /**
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
