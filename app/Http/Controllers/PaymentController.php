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
            // Получаем контакт
            $contact = Contact::findOrFail($id);

            // Инициализация Stripe
            Stripe::setApiKey(config('services.stripe.secret'));
            
            // Создание PaymentIntent
            $paymentIntent = PaymentIntent::create([
                'amount' => ($contact->amount + 21) * 100, // конвертация в центы
                'currency' => 'usd',
                'metadata' => [
                    'contact_id' => $contact->id
                ]
            ]);

            return view('payment', [
                'contact' => $contact,
                'clientSecret' => $paymentIntent->client_secret
            ]);

        } catch (\Exception $e) {
            \Log::error('Payment error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error loading payment page');
        }
    }
}