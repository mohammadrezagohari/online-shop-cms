<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Attachment;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use phpDocumentor\Reflection\File;

class SendEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject;
    public string $body;
    public ?string $attachment;

    /**
     * Create a new message instance.
     */
    public function __construct(string $subject, string $body, string $attachment = null)
    {
        $this->subject = $subject;
        $this->body = $body;
        $this->attachment = $attachment;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('m.ebrahimi.talo1990@gmail.com', "online-shop-cms-main"),
            subject: $this->subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.sendEmail',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        if ($this->attachment) {
            return [
                Attachment::fromPath(public_path($this->attachment)),
            ];
        } else {
            return [

            ];
        }


    }
}
