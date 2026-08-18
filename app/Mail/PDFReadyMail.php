<?php

namespace App\Mail;

use App\Models\Ready;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PDFReadyMail extends Mailable
{
    use SerializesModels;

    public function __construct(public Ready $ready) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Download your Labels PDF : '.$this->ready->set->name,
            cc: ['rohan@saiashirwad.com'],
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.pdf_ready',
            with: [
                'ready' => $this->ready,
            ],
        );
    }

    public function attachments(): array
    {
        return [
            Attachment::fromStorageDisk('public', $this->ready->path)
                ->as($this->ready->set->name.'.pdf')
                ->withMime('application/pdf'),
        ];
    }
}