<?php

namespace App\Mail;

use App\Models\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $contact;
    public $paymentIntent;

    public function __construct(Contact $contact, $paymentIntent)
    {
        $this->contact = $contact;
        $this->paymentIntent = $paymentIntent;
    }

    public function build()
    {
        return $this->subject('Payment Confirmation for Your LEI Registration')
                   ->view('emails.user.payment-confirmation');
    }
}