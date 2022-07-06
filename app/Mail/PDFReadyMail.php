<?php

namespace App\Mail;

use App\Models\Ready;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PDFReadyMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public Ready $ready;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Ready $ready)
    {
        $this->ready = $ready;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.pdf_ready')
            ->subject('Download your Labels PDF : '.$this->ready->set->name);
    }
}
