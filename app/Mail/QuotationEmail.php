<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class QuotationEmail extends Mailable
{
    public $quotation;
    public $password;
    public $pdfPath;
    public $loginUrl;

    public function __construct($quotation, $password, $pdfPath)
    {
        $this->quotation = $quotation;
        $this->password = $password;
        $this->pdfPath = $pdfPath;
        $this->loginUrl = route('customer.login'); // ✅ add this
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