<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Mail\UserRegistrationConfirmation;
use App\Mail\AdminRegistrationNotification;
use Illuminate\Support\Facades\Mail;
use App\Models\Contact;
use Illuminate\Support\Facades\Auth;

class GleifController extends Controller
{
    // GLEIF API base URL
    protected $apiUrl = 'https://api.gleif.org/api/v1';
    
    /**
     * Search for LEIs by company name
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchByName(Request $request)
    {
        try {
            $query = $request->input('query');
            
            if (empty($query)) {
                return response()->json(['error' => 'Search query is required'], 400);
            }
            
            $response = Http::get($this->apiUrl . '/lei-records', [
                'filter[entity.legalName]' => $query,
                'page[size]' => 100
            ]);
            
            if (!$response->successful()) {
                Log::error('GLEIF API Error: ' . $response->body());
                return response()->json(['error' => 'Error fetching data from GLEIF API'], 500);
            }
            
            return response()->json($response->json());
            
        } catch (\Exception $e) {
            Log::error('GLEIF search error: ' . $e->getMessage());
            return response()->json(['error' => 'Internal server error'], 500);
        }
    }
    
    /**
     * Get LEI details by LEI code
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getLeiDetails(Request $request)
    {
        try {
            $lei = $request->input('lei');
            
            if (empty($lei)) {
                return response()->json(['error' => 'LEI code is required'], 400);
            }
            
            // Validate LEI format
            if (!preg_match('/^[A-Z0-9]{20}$/', $lei)) {
                return response()->json(['error' => 'Invalid LEI format'], 400);
            }
            
            $response = Http::get($this->apiUrl . '/lei-records/' . $lei);
            
            if ($response->status() === 404) {
                return response()->json(['error' => 'LEI not found'], 404);
            }
            
            if (!$response->successful()) {
                Log::error('GLEIF API Error: ' . $response->body());
                return response()->json(['error' => 'Error fetching data from GLEIF API'], 500);
            }
            
            return response()->json($response->json());
            
        } catch (\Exception $e) {
            Log::error('GLEIF details error: ' . $e->getMessage());
            return response()->json(['error' => 'Internal server error'], 500);
        }
    }
    
    /**
     * Search for companies by registration ID
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function searchByRegistrationId(Request $request)
    {
        try {
            $registrationId = $request->input('registration_id');
            $country = $request->input('country');
            
            if (empty($registrationId) || empty($country)) {
                return response()->json(['error' => 'Registration ID and country are required'], 400);
            }
            
            $response = Http::get($this->apiUrl . '/lei-records', [
                'filter[entity.registeredAs]' => $registrationId,
                'filter[entity.legalAddress.country]' => $country
            ]);
            
            if (!$response->successful()) {
                Log::error('GLEIF API Error: ' . $response->body());
                return response()->json(['error' => 'Error fetching data from GLEIF API'], 500);
            }
            
            return response()->json($response->json());
            
        } catch (\Exception $e) {
            Log::error('GLEIF registration search error: ' . $e->getMessage());
            return response()->json(['error' => 'Internal server error'], 500);
        }
    }
    
    /**
     * Process new LEI registration
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function processRegistration(Request $request)
    {
        try {
            // Log the incoming request
            \Log::info('Registration form received', $request->all());
            
            // Basic validation
            $validated = $request->validate([
                'country' => 'required|string',
                'full_name' => 'required|string|max:255',
                'legal_entity_name' => 'required|string|max:255',
                'email' => 'required|email',
                'phone' => 'required',
                'address' => 'required',
                'city' => 'required',
                'zip_code' => 'required',
                'terms' => 'required',
                'selected_plan' => 'required'
            ]);
            
            // Create a new contact record
            $contact = new \App\Models\Contact();
            $contact->type = 'registration';
            $contact->full_name = $request->input('full_name');
            $contact->legal_entity_name = $request->input('legal_entity_name');
            $contact->registration_id = $request->input('registration_id');
            $contact->country = $request->input('country');
            $contact->email = $request->input('email');
            $contact->phone = $request->input('phone');
            $contact->address = $request->input('address');
            $contact->city = $request->input('city');
            $contact->zip_code = $request->input('zip_code');
            $contact->selected_plan = $request->input('selected_plan');
            $contact->same_address = $request->input('same_address', true);
            $contact->private_controlled = $request->input('private_controlled', false);
            $contact->payment_status = 'pending';
            
            // Set plan amount based on selected plan
            $planPrices = [
                '1-year' => 75.00,
                '3-years' => 195.00,
                '5-years' => 275.00
            ];
            $contact->amount = $planPrices[$contact->selected_plan] ?? 75.00;
            
            // Associate with logged-in user if exists
            if (Auth::check()) {
                $contact->user_id = Auth::id();
            }
            
            $contact->save();

            // Send confirmation email to user
            try {
                Mail::to($contact->email)->send(new UserRegistrationConfirmation($contact));
            } catch (\Exception $mailException) {
                \Log::error('Failed to send user confirmation email: ' . $mailException->getMessage());
            }
            
            // Send notification to admin
            try {
                Mail::to(config('mail.admin_email', 'info@lei-register.co.uk'))
                    ->send(new AdminRegistrationNotification($contact));
            } catch (\Exception $mailException) {
                \Log::error('Failed to send admin notification email: ' . $mailException->getMessage());
            }
            
            // Get the ID for redirection
            $contactId = $contact->id;
            
            // Log the redirect attempt
            \Log::info('Redirecting to payment page', ['order_id' => $contactId]);

            // If this is an AJAX/fetch request, return JSON
            if ($request->expectsJson()) {
                return response()->json([
                    'success'  => true,
                    'redirect' => route('payment.show', ['id' => $contactId]),
                ]);
            }

           // Fallback: full-page redirect
           return redirect()->route('payment.show', ['id' => $contactId]);
            
        } catch (\Exception $e) {
            // Log the error
            \Log::error('Registration error: ' . $e->getMessage());
            
            // Return with error
            return redirect()->back()
                    ->with('error', 'An error occurred: ' . $e->getMessage())
                    ->withInput();
        }
    }

    /**
     * Process LEI renewal
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function processRenewal(Request $request)
    {
        try {
            // Detailed logging of the incoming request
            \Log::info('Renewal request received', $request->all());
            
            $lei = $request->input('lei');
            $period = $request->input('renewal_period', '1-year');
            
            \Log::info('LEI and period extracted', ['lei' => $lei, 'period' => $period]);
            
            if (empty($lei)) {
                \Log::warning('LEI code is missing in renewal request');
                return redirect()->back()->with('error', 'LEI code is required');
            }
            
            // Validate LEI format
            if (!preg_match('/^[A-Z0-9]{20}$/', $lei)) {
                \Log::warning('Invalid LEI format in renewal request', ['lei' => $lei]);
                return redirect()->back()->with('error', 'Invalid LEI format');
            }
            
            // Check if this LEI belongs to the logged-in user (if authenticated)
            if (Auth::check()) {
                $existingLei = Contact::where('registration_id', $lei)
                    ->where('user_id', Auth::id())
                    ->first();
                
                if (!$existingLei) {
                    // Check if LEI exists but belongs to another user
                    $leiExists = Contact::where('registration_id', $lei)->exists();
                    if ($leiExists) {
                        return redirect()->back()->with('error', 'This LEI is not associated with your account.');
                    }
                }
            }
            
            // Create a new contact for the renewal
            $contact = new \App\Models\Contact();
            
            // Check if Contact model was created
            if (!$contact) {
                \Log::error('Failed to create Contact model instance');
                return redirect()->back()->with('error', 'System error: Failed to create contact record');
            }
            
            \Log::info('Setting contact properties');
            
            // Fill required fields with default values if necessary
            $contact->type = 'renewal';
            $contact->legal_entity_name = $request->input('legal_entity_name', 'LEI Renewal - ' . $lei);
            $contact->registration_id = $lei;
            $contact->email = $request->input('email', Auth::check() ? Auth::user()->email : '');
            $contact->phone = $request->input('phone', '');
            $contact->country = $request->input('country', '');
            $contact->address = $request->input('address', '');
            $contact->city = $request->input('city', '');
            $contact->zip_code = $request->input('zip_code', '');
            $contact->selected_plan = $period;
            $contact->payment_status = 'pending';
            $contact->same_address = true;
            $contact->private_controlled = false;
            $contact->full_name = $request->input('full_name', Auth::check() ? Auth::user()->name : '');
            
            // Associate with logged-in user if exists
            if (Auth::check()) {
                $contact->user_id = Auth::id();
            }
            
            // Set plan amount based on period
            switch ($period) {
                case '1-year':
                    $contact->amount = 75.00;
                    break;
                case '3-years':
                    $contact->amount = 195.00;
                    break;
                case '5-years':
                    $contact->amount = 275.00;
                    break;
                default:
                    $contact->amount = 75.00;
            }
            
            \Log::info('Attempting to save contact', [
                'legal_entity_name' => $contact->legal_entity_name,
                'registration_id' => $contact->registration_id,
                'email' => $contact->email,
                'selected_plan' => $contact->selected_plan,
                'amount' => $contact->amount,
                'user_id' => $contact->user_id
            ]);
            
            $contact->save();
            
            \Log::info('Contact saved successfully with ID: ' . $contact->id);
            
            // Redirect to payment page
            return redirect()->route('payment.show', [
                'id' => $contact->id
            ]);
            
        } catch (\Exception $e) {
            \Log::error('LEI renewal error details: ' . $e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()->with('error', 'An error occurred during the renewal process: ' . $e->getMessage());
        }
    }
    
    /**
     * Process LEI transfer
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function processTransfer(Request $request)
    {
        try {
            $lei = $request->input('lei');
            $email = $request->input('email');
            $transferReason = $request->input('transfer_reason');
            
            if (empty($lei) || empty($email)) {
                return redirect()->back()->with('error', 'LEI code and email are required');
            }
            
            // Validate LEI format
            if (!preg_match('/^[A-Z0-9]{20}$/', $lei)) {
                return redirect()->back()->with('error', 'Invalid LEI format');
            }
            
            // Check if this LEI belongs to the logged-in user (if authenticated)
            if (Auth::check()) {
                $existingLei = Contact::where('registration_id', $lei)
                    ->where('user_id', Auth::id())
                    ->first();
                
                if (!$existingLei) {
                    // Check if LEI exists but belongs to another user
                    $leiExists = Contact::where('registration_id', $lei)->exists();
                    if ($leiExists) {
                        return redirect()->back()->with('error', 'This LEI is not associated with your account.');
                    }
                }
            }
            
            // Verify LEI exists and is eligible for transfer
            try {
                $response = Http::get($this->apiUrl . '/lei-records/' . $lei);
                
                if ($response->status() === 404) {
                    return redirect()->back()->with('error', 'LEI not found');
                }
                
                if (!$response->successful()) {
                    Log::error('GLEIF API Error: ' . $response->body());
                    return redirect()->back()->with('error', 'Error verifying LEI with GLEIF');
                }
                
                $leiData = $response->json();
                
                // Check if LEI status allows transfer
                $status = $leiData['data']['attributes']['registration']['status'] ?? null;
                if ($status !== 'ISSUED') {
                    return redirect()->back()->with('error', 'This LEI is not eligible for transfer');
                }
                
                // Store transfer request in database
                $contact = new \App\Models\Contact();
                $contact->type = 'transfer';
                $contact->registration_id = $lei;
                $contact->email = $email;
                $contact->legal_entity_name = $leiData['data']['attributes']['entity']['legalName']['name'] ?? 'Unknown';
                $contact->transfer_reason = $transferReason;
                $contact->payment_status = 'pending';
                $contact->full_name = Auth::check() ? Auth::user()->name : '';
                $contact->country = '';
                $contact->phone = '';
                $contact->address = '';
                $contact->city = '';
                $contact->zip_code = '';
                $contact->selected_plan = '1-year'; // Default plan for transfers
                $contact->amount = 75.00; // Default amount for transfers
                
                // Associate with logged-in user if exists
                if (Auth::check()) {
                    $contact->user_id = Auth::id();
                }
                
                $contact->save();
                
                // Redirect to confirmation page
                return redirect()->route('transfer.confirmation')->with([
                    'success' => 'Transfer request submitted successfully',
                    'lei' => $lei,
                    'company' => $contact->legal_entity_name
                ]);
            } catch (\Exception $apiException) {
                Log::error('GLEIF API communication error: ' . $apiException->getMessage());
                
                // Create a contact entry even if API verification fails
                $contact = new \App\Models\Contact();
                $contact->type = 'transfer';
                $contact->registration_id = $lei;
                $contact->email = $email;
                $contact->legal_entity_name = 'LEI Transfer Request';
                $contact->transfer_reason = $transferReason;
                $contact->payment_status = 'pending';
                $contact->full_name = Auth::check() ? Auth::user()->name : '';
                $contact->country = '';
                $contact->phone = '';
                $contact->address = '';
                $contact->city = '';
                $contact->zip_code = '';
                $contact->selected_plan = '1-year';
                $contact->amount = 75.00;
                
                // Associate with logged-in user if exists
                if (Auth::check()) {
                    $contact->user_id = Auth::id();
                }
                
                $contact->save();
                
                // Still redirect to confirmation
                return redirect()->route('transfer.confirmation')->with([
                    'success' => 'Transfer request submitted successfully',
                    'lei' => $lei
                ]);
            }
                
        } catch (\Exception $e) {
            Log::error('LEI transfer error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred during the transfer process: ' . $e->getMessage());
        }
    }
    
    /**
     * Process bulk LEI registration request
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function processBulkRegistration(Request $request)
    {
        try {
            // Validate form data
            $validated = $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'company_name' => 'required|string|max:255',
                'country' => 'required|string|size:2',
                'email' => 'required|email|max:255',
                'phone' => 'required|string|max:50',
                'terms' => 'required',
            ]);
            
            // Create a contact record for bulk registration inquiry
            $contact = new Contact();
            $contact->type = 'bulk_registration';
            $contact->full_name = $validated['first_name'] . ' ' . $validated['last_name'];
            $contact->legal_entity_name = $validated['company_name'];
            $contact->country = $validated['country'];
            $contact->email = $validated['email'];
            $contact->phone = $validated['phone'];
            $contact->payment_status = 'inquiry';
            $contact->registration_id = 'BULK-' . time();
            $contact->address = '';
            $contact->city = '';
            $contact->zip_code = '';
            $contact->selected_plan = 'bulk';
            $contact->amount = 0;
            
            // Associate with logged-in user if exists
            if (Auth::check()) {
                $contact->user_id = Auth::id();
            }
            
            $contact->save();
            
            // Send notification email to admin
            try {
                Mail::to(config('mail.admin_email', 'info@lei-register.co.uk'))
                    ->send(new \App\Mail\BulkRegistrationInquiry($contact));
            } catch (\Exception $mailException) {
                Log::error('Failed to send bulk registration notification: ' . $mailException->getMessage());
            }
            
            // Redirect to confirmation page
            return redirect()->route('bulk.confirmation')->with('success', 'Bulk registration request submitted successfully');
            
        } catch (\Exception $e) {
            Log::error('Bulk registration error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while submitting your request')->withInput();
        }
    }
}