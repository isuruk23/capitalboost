<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class QuotationEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $quotation;
    public $password;
    public $pdfPath;

    public function __construct($quotation, $password, $pdfPath)
    {
        $this->quotation = $quotation;
        $this->password = $password;
        $this->pdfPath = $pdfPath;
    }

    public function build()
    {
        return $this->subject('Your Quotation & Portal Login Details')
            ->view('emails.quotation')
            ->attach($this->pdfPath, [
                'as' => 'quotation.pdf',
                'mime' => 'application/pdf',
            ]);
    }
}
