<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Stripe\Exception\ApiErrorException;
use App\Mail\PaymentConfirmation;
use App\Mail\AdminPaymentNotification;
use Illuminate\Support\Facades\Mail;

class PaymentController extends Controller
{
    /**
     * Display the payment form for a specific contact
     */
    public function show($id)
    {
        try {
            // Find the contact by ID
            $contact = Contact::findOrFail($id);
            
            // Set your Stripe API key
            Stripe::setApiKey(config('services.stripe.secret'));
            
            // Calculate the amount based on the selected plan
            $amount = $this->calculateAmount($contact);
            
            // Create a payment intent
            $paymentIntent = PaymentIntent::create([
                'amount' => $amount * 100, // Stripe requires amount in cents
                'currency' => 'eur',
                'metadata' => [
                    'contact_id' => $contact->id,
                    'plan' => $contact->selected_plan,
                    'service_type' => 'standard', // Default to standard service
                ],
                'description' => "LEI Registration for {$contact->legal_entity_name}",
            ]);
            
            // Return the payment page with the client secret
            return view('payment.show', [
                'contact' => $contact,
                'clientSecret' => $paymentIntent->client_secret,
                'amount' => $amount
            ]);
        } catch (\Exception $e) {
            Log::error('Payment error: ' . $e->getMessage());
            return redirect()->route('home')->with('error', 'There was a problem processing your payment. Please try again.');
        }
    }
    
    /**
     * Calculate the amount based on the selected plan
     */
    private function calculateAmount($contact)
    {
        $planPrices = [
            '1-year' => 75.00,
            '3-years' => 165.00,
            '5-years' => 250.00
        ];
        
        return $planPrices[$contact->selected_plan] ?? 75.00;
    }
    
    /**
     * Handle successful payment
     */
    public function success(Request $request, $paymentIntentId)
    {
        try {
            // Set your Stripe API key
            Stripe::setApiKey(config('services.stripe.secret'));
            
            // Retrieve the payment intent
            $paymentIntent = PaymentIntent::retrieve($paymentIntentId);
            
            // Get the contact ID from the metadata
            $contactId = $paymentIntent->metadata->contact_id;
            
            // Update the contact's payment status
            $contact = Contact::findOrFail($contactId);
            $contact->payment_status = 'paid';
            $contact->save();

            // Send payment confirmation to user
            Mail::to($contact->email)
                ->send(new PaymentConfirmation($contact, $paymentIntent));
            
            // Send payment notification to admin
            Mail::to(config('mail.admin_email', 'info@lei-register.co.uk'))
                ->send(new AdminPaymentNotification($contact, $paymentIntent));
            
            // Return the success page
            return view('payment.success', [
                'contact' => $contact,
                'paymentIntent' => $paymentIntent
            ]);
        } catch (\Exception $e) {
            Log::error('Payment success error: ' . $e->getMessage());
            return redirect()->route('home')->with('error', 'There was a problem updating your payment status. Please contact support.');
        }
    }
    
    /**
     * Handle failed payment
     */
    public function failed(Request $request)
    {
        return view('payment.failed');
    }
    
    /**
     * Handle Stripe webhooks
     */
    public function handleWebhook(Request $request)
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $endpointSecret = config('services.stripe.webhook_secret');
        
        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload, $sigHeader, $endpointSecret
            );
            
            // Handle the event
            switch ($event->type) {
                case 'payment_intent.succeeded':
                    $this->handleSuccessfulPayment($event->data->object);
                    break;
                case 'payment_intent.payment_failed':
                    $this->handleFailedPayment($event->data->object);
                    break;
                default:
                    Log::info('Unhandled event type: ' . $event->type);
            }
            
            return response()->json(['status' => 'success']);
        } catch (\UnexpectedValueException $e) {
            Log::error('Invalid payload: ' . $e->getMessage());
            return response()->json(['error' => 'Invalid payload'], 400);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            Log::error('Invalid signature: ' . $e->getMessage());
            return response()->json(['error' => 'Invalid signature'], 400);
        } catch (\Exception $e) {
            Log::error('Webhook error: ' . $e->getMessage());
            return response()->json(['error' => 'Webhook error'], 400);
        }
    }
    
    /**
     * Handle successful payment webhook
     */
    private function handleSuccessfulPayment($paymentIntent)
    {
        if (isset($paymentIntent->metadata->contact_id)) {
            $contactId = $paymentIntent->metadata->contact_id;
            
            $contact = Contact::find($contactId);
            if ($contact) {
                $contact->payment_status = 'paid';
                $contact->save();
                
                // Send email notifications
                try {
                    // Send payment confirmation to user
                    Mail::to($contact->email)
                        ->send(new PaymentConfirmation($contact, $paymentIntent));
                    
                    // Send payment notification to admin
                    Mail::to(config('mail.admin_email', 'info@lei-register.co.uk'))
                        ->send(new AdminPaymentNotification($contact, $paymentIntent));
                    
                    Log::info('Payment success emails sent for contact ID: ' . $contactId);
                } catch (\Exception $e) {
                    Log::error('Failed to send payment success emails: ' . $e->getMessage());
                }
            } else {
                Log::error('Contact not found for payment: ' . $contactId);
            }
        }
    }
    
    /**
     * Handle failed payment webhook
     */
    private function handleFailedPayment($paymentIntent)
    {
        if (isset($paymentIntent->metadata->contact_id)) {
            $contactId = $paymentIntent->metadata->contact_id;
            
            $contact = Contact::find($contactId);
            if ($contact) {
                $contact->payment_status = 'failed';
                $contact->save();
                
                Log::info('Payment failed for contact ID: ' . $contactId);
            }
        }
    }
    
    /**
     * Create payment intent API endpoint
     */
    public function createIntent(Request $request)
    {
        try {
            // Set your Stripe API key
            Stripe::setApiKey(config('services.stripe.secret'));
            
            $contactId = $request->input('contact_id');
            $serviceType = $request->input('service_type', 'standard');
            
            // Find the contact
            $contact = Contact::findOrFail($contactId);
            
            // Calculate the amount
            $baseAmount = $this->calculateAmount($contact);
            $serviceAmount = $serviceType === 'complete' ? 21.00 : 0.00;
            $totalAmount = $baseAmount + $serviceAmount;
            
            // Create a payment intent
            $paymentIntent = PaymentIntent::create([
                'amount' => $totalAmount * 100, // Stripe requires amount in cents
                'currency' => 'eur',
                'metadata' => [
                    'contact_id' => $contactId,
                    'plan' => $contact->selected_plan,
                    'service_type' => $serviceType,
                ],
                'description' => "LEI Registration for {$contact->legal_entity_name}",
            ]);
            
            return response()->json([
                'clientSecret' => $paymentIntent->client_secret
            ]);
        } catch (ApiErrorException $e) {
            Log::error('Stripe API error: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 400);
        } catch (\Exception $e) {
            Log::error('Payment intent error: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to create payment intent'], 500);
        }
    }
}