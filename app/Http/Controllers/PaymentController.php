<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class PaymentController extends Controller
{
    public function show($id)
{
    try {
        // If $id is numeric, find the contact
        if (is_numeric($id)) {
            $contact = \App\Models\Contact::findOrFail($id);
            
            return view('payment.show', [
                'contact' => $contact
            ]);
        }
        
        // If $id is 'registration', 'renewal', or 'transfer', handle it differently
        if (in_array($id, ['registration', 'renewal', 'transfer'])) {
            return view('payment.show', [
                'type' => $id,
                'amount' => $this->getAmountByType($id)
            ]);
        }
        
        throw new \Exception("Invalid payment ID: {$id}");
        
    } catch (\Exception $e) {
        \Log::error('Payment error: ' . $e->getMessage());
        return redirect()->route('home')->with('error', 'There was a problem processing your payment. Please try again.');
    }
}

private function getAmountByType($type)
{
    switch ($type) {
        case 'registration':
            return 75.00; // Default amount for registration
        case 'renewal':
            return 75.00; // Default amount for renewal
        case 'transfer':
            return 75.00; // Default amount for transfer
        default:
            return 75.00;
    }
}

}