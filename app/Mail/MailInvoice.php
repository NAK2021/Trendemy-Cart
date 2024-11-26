<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Support\Facades\Storage;

class MailInvoice extends Mailable
{
    use Queueable, SerializesModels;


    public function __construct(
        public $view,
        public $subject,
        public $attachment
    ) {
        //
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subject
        );
    }

    public function content(): Content
    {
        return new Content(
            view: $this->view,
        );
    }

    public function attachments(): array
    {
        return [

            Attachment::fromPath(Storage::path($this->attachment))
                ->as('invoice.pdf')
                ->withMime('application/pdf'),
        ];
    }
}
