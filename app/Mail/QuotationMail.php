<?php

namespace App\Mail;

use App\Models\Company;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Barryvdh\DomPDF\Facade\Pdf;

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
                     ->view('email') 
                     ->with([
                         'quotation' => $this->quotation,
                         'shareLink' => $this->shareLink,
                     ]);

        if ($this->attach) {
            $mail = $this->attachPDF($mail);
        }

        return $mail;
    }

    protected function attachPDF($mail)
    {
        $company = Company::first();

        // Generate PDF
        $pdf = Pdf::loadView('quotations.pdf', [
            'quotation' => $this->quotation,
            'company' => $company
        ]);

        // Save PDF
        $pdfPath = storage_path("app/quotations/quotation_{$this->quotation->id}.pdf");
        if (!file_exists(dirname($pdfPath))) {
            mkdir(dirname($pdfPath), 0777, true);
        }
        $pdf->save($pdfPath);

        // Attach PDF
        if (file_exists($pdfPath)) {
            $mail->attach($pdfPath, [
                'as' => "Quotation_{$this->quotation->id}.pdf",
                'mime' => 'application/pdf',
            ]);
        } else {
            \Log::error("PDF not created for quotation ID {$this->quotation->id}");
        }

        return $mail;
    }
}