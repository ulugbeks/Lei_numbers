<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Contact;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show user profile dashboard
     *
     * @return \Illuminate\View\View
     */
    public function profile()
    {
        $user = Auth::user();
        
        // Get all LEI registrations for the user
        $leiRegistrations = $user->leiRegistrations()
            ->whereIn('type', ['registration', 'renewal', 'transfer'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.profile', compact('user', 'leiRegistrations'));
    }

    /**
     * Update user profile information
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        // Validate the request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
        ]);

        if ($validator->fails()) {
            return redirect()->route('user.profile')
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Please check your input and try again.');
        }

        try {
            // Update user information
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            
            // Add phone to users table if column exists
            if (in_array('phone', $user->getFillable())) {
                $user->phone = $request->input('phone');
            }
            
            $user->save();

            return redirect()->route('user.profile')
                ->with('success', 'Profile updated successfully!');
                
        } catch (\Exception $e) {
            return redirect()->route('user.profile')
                ->with('error', 'An error occurred while updating your profile. Please try again.')
                ->withInput();
        }
    }

    /**
     * Update user password
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatePassword(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->route('user.profile')
                ->withErrors($validator)
                ->with('error', 'Please check your password input.')
                ->with('tab', 'change-password');
        }

        $user = Auth::user();

        // Check if current password is correct
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->route('user.profile')
                ->with('error', 'Current password is incorrect')
                ->with('tab', 'change-password');
        }

        try {
            // Update password
            $user->password = Hash::make($request->new_password);
            $user->save();

            return redirect()->route('user.profile')
                ->with('success', 'Password updated successfully!')
                ->with('tab', 'change-password');
                
        } catch (\Exception $e) {
            return redirect()->route('user.profile')
                ->with('error', 'An error occurred while updating your password. Please try again.')
                ->with('tab', 'change-password');
        }
    }

    /**
     * Renew LEI from profile
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function renewLei($id)
    {
        try {
            // Find the contact and verify it belongs to the authenticated user
            $contact = Contact::where('user_id', Auth::id())
                ->where('id', $id)
                ->firstOrFail();
            
            // Check if LEI is eligible for renewal
            if ($contact->payment_status !== 'paid') {
                return redirect()->route('user.profile')
                    ->with('error', 'This LEI is not eligible for renewal yet.')
                    ->with('tab', 'lei-history');
            }
            
            // Store renewal data in session
            session([
                'renewal_mode' => true,
                'renewal_lei' => $contact->registration_id,
                'renewal_data' => [
                    'legal_entity_name' => $contact->legal_entity_name,
                    'email' => $contact->email,
                    'phone' => $contact->phone,
                    'country' => $contact->country,
                    'address' => $contact->address,
                    'city' => $contact->city,
                    'zip_code' => $contact->zip_code,
                ]
            ]);
            
            // Redirect to registration page with renewal mode
            return redirect()->route('registration-lei')
                ->with('info', 'Renewing LEI for ' . $contact->legal_entity_name);
                
        } catch (\Exception $e) {
            return redirect()->route('user.profile')
                ->with('error', 'Unable to process renewal request.')
                ->with('tab', 'lei-history');
        }
    }

    /**
     * Transfer LEI from profile
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function transferLei($id)
    {
        try {
            // Find the contact and verify it belongs to the authenticated user
            $contact = Contact::where('user_id', Auth::id())
                ->where('id', $id)
                ->firstOrFail();
            
            // Check if LEI is eligible for transfer
            if ($contact->payment_status !== 'paid' || empty($contact->registration_id)) {
                return redirect()->route('user.profile')
                    ->with('error', 'This LEI is not eligible for transfer.')
                    ->with('tab', 'lei-history');
            }
            
            // Store transfer data in session
            session([
                'transfer_mode' => true,
                'transfer_lei' => $contact->registration_id,
                'transfer_data' => [
                    'legal_entity_name' => $contact->legal_entity_name,
                    'email' => $contact->email,
                ]
            ]);
            
            // Redirect to registration page with transfer mode
            return redirect()->route('registration-lei')
                ->with('info', 'Transferring LEI: ' . $contact->registration_id);
                
        } catch (\Exception $e) {
            return redirect()->route('user.profile')
                ->with('error', 'Unable to process transfer request.')
                ->with('tab', 'lei-history');
        }
    }

    /**
     * View LEI details
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function viewLeiDetails($id)
    {
        try {
            $contact = Contact::where('user_id', Auth::id())
                ->where('id', $id)
                ->firstOrFail();
                
            return view('user.lei-details', compact('contact'));
            
        } catch (\Exception $e) {
            return redirect()->route('user.profile')
                ->with('error', 'LEI registration not found.')
                ->with('tab', 'lei-history');
        }
    }

    /**
     * Download LEI certificate (if available)
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function downloadLeiCertificate($id)
    {
        try {
            $contact = Contact::where('user_id', Auth::id())
                ->where('id', $id)
                ->where('payment_status', 'paid')
                ->firstOrFail();
                
            // Check if certificate exists
            if (empty($contact->certificate_path) || !Storage::exists($contact->certificate_path)) {
                return redirect()->route('user.profile')
                    ->with('error', 'Certificate not available yet.')
                    ->with('tab', 'lei-history');
            }
            
            return Storage::download($contact->certificate_path, 'LEI_Certificate_' . $contact->registration_id . '.pdf');
            
        } catch (\Exception $e) {
            return redirect()->route('user.profile')
                ->with('error', 'Unable to download certificate.')
                ->with('tab', 'lei-history');
        }
    }

    /**
     * Get user's LEI statistics
     *
     * @return array
     */
    private function getUserLeiStatistics()
    {
        $user = Auth::user();
        
        $statistics = [
            'total_leis' => $user->leiRegistrations()->count(),
            'active_leis' => $user->leiRegistrations()->where('payment_status', 'paid')->count(),
            'pending_leis' => $user->leiRegistrations()->where('payment_status', 'pending')->count(),
            'total_spent' => $user->leiRegistrations()->where('payment_status', 'paid')->sum('amount'),
        ];
        
        return $statistics;
    }
}