<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class QuotationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $quotation;
    public $shareLink;
    public $attach;

    public function __construct($quotation, $shareLink = null, $attach = false)
    {
        $this->quotation = $quotation;
        $this->shareLink = $shareLink;
        $this->attach = $attach;
    }

    public function build()
    {
        $mail = $this->subject("Quotation #{$this->quotation->id}")
            ->view('emails.quotation');

        if ($this->attach) {
            $mail->attach(storage_path("app/quotations/quotation_{$this->quotation->id}.pdf"));
        }

        return $mail;
    }
}
