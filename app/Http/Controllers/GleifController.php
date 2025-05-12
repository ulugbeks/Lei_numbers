<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Mail\UserRegistrationConfirmation;
use App\Mail\AdminRegistrationNotification;
use Illuminate\Support\Facades\Mail;

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
     * Process LEI renewal
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function processRenewal(Request $request)
    {
        try {
            $lei = $request->input('selected_lei');
            $period = $request->input('renewal_period', 1);
            
            if (empty($lei)) {
                return redirect()->back()->with('error', 'LEI code is required');
            }
            
            // Validate LEI format
            if (!preg_match('/^[A-Z0-9]{20}$/', $lei)) {
                return redirect()->back()->with('error', 'Invalid LEI format');
            }
            
            // Verify LEI exists and is eligible for renewal
            $response = Http::get($this->apiUrl . '/lei-records/' . $lei);
            
            if ($response->status() === 404) {
                return redirect()->back()->with('error', 'LEI not found');
            }
            
            if (!$response->successful()) {
                Log::error('GLEIF API Error: ' . $response->body());
                return redirect()->back()->with('error', 'Error verifying LEI with GLEIF');
            }
            
            $leiData = $response->json();
            
            // Check if LEI status allows renewal
            $status = $leiData['data']['attributes']['registration']['status'] ?? null;
            if ($status !== 'ISSUED' && $status !== 'LAPSED') {
                return redirect()->back()->with('error', 'This LEI is not eligible for renewal');
            }
            
            // Store renewal request in database
            // This would be implemented based on your application's data model
            
            // Redirect to payment page with the renewal details
            return redirect()->route('payment.show', [
                'type' => 'renewal',
                'lei' => $lei,
                'period' => $period
            ])->with('success', 'LEI verification successful');
            
        } catch (\Exception $e) {
            Log::error('LEI renewal error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred during the renewal process');
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
            
            // Verify LEI exists and is eligible for transfer
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
            // This would be implemented based on your application's data model
            
            // Redirect to confirmation page
            return redirect()->route('transfer.confirmation')->with([
                'success' => 'Transfer request submitted successfully',
                'lei' => $lei,
                'company' => $leiData['data']['attributes']['entity']['legalName']['name'] ?? 'Unknown'
            ]);
            
        } catch (\Exception $e) {
            Log::error('LEI transfer error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred during the transfer process');
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
            $contact->country = $request->input('country');
            $contact->email = $request->input('email');
            $contact->phone = $request->input('phone');
            $contact->address = $request->input('address');
            $contact->city = $request->input('city');
            $contact->zip_code = $request->input('zip_code');
            $contact->selected_plan = $request->input('selected_plan');
            $contact->save();

            // Send confirmation email to user
            Mail::to($contact->email)->send(new UserRegistrationConfirmation($contact));
            
            // Send notification to admin
            Mail::to(config('mail.admin_email', 'info@lei-register.co.uk'))
                ->send(new AdminRegistrationNotification($contact));
            
            // Get the ID for redirection
            $contactId = $contact->id;
            
            // Log the redirect attempt
            \Log::info('Redirecting to payment page', ['order_id' => $orderId]);
            
            // Perform a direct redirect instead of using named routes
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
            
            // Store bulk registration inquiry in database
            // This would be implemented based on your application's data model
            
            // Send notification email to staff
            // This would be implemented using Laravel's mail functionality
            
            // Redirect to confirmation page
            return redirect()->route('bulk.confirmation')->with('success', 'Bulk registration request submitted successfully');
            
        } catch (\Exception $e) {
            Log::error('Bulk registration error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while submitting your request')->withInput();
        }
    }
}