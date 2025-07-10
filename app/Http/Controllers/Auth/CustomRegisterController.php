<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class CustomRegisterController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Show the registration form
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        return view('auth.custom-register');
    }

    /**
     * Handle registration request
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(Request $request)
    {
        // Validate the form data
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->except('password', 'password_confirmation'));
        }

        try {
            // Create the user
            $user = $this->create($request->all());

            // Fire the registered event
            event(new Registered($user));

            // Send welcome email (optional - check if mail class exists)
            if (class_exists('App\Mail\WelcomeEmail')) {
                try {
                    Mail::to($user->email)->send(new \App\Mail\WelcomeEmail($user));
                } catch (\Exception $mailException) {
                    // Log mail error but don't stop registration
                    Log::error('Failed to send welcome email: ' . $mailException->getMessage());
                }
            }

            // Log the user in
            Auth::login($user);

            // Log the registration
            Log::info('New user registered', ['user_id' => $user->id, 'email' => $user->email]);

            // Check if user was trying to access a protected page
            if (session()->has('url.intended')) {
                return redirect()->intended();
            }

            // Redirect to profile with success message
            return redirect()->route('user.profile')
                ->with('success', 'Welcome! Your account has been created successfully.');

        } catch (\Exception $e) {
            // Log the error
            Log::error('Registration error: ' . $e->getMessage());

            return redirect()->back()
                ->withInput($request->except('password', 'password_confirmation'))
                ->with('error', 'An error occurred during registration. Please try again.');
        }
    }

    /**
     * Get a validator for an incoming registration request
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            // Account Information
            'username' => ['required', 'string', 'max:255', 'unique:users', 'regex:/^[a-zA-Z0-9_]+$/'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            
            // User Details
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'suffix' => ['nullable', 'string', 'max:50'],
            'company_name' => ['required', 'string', 'max:255'],
            'phone_country_code' => ['nullable', 'string', 'max:10'],
            'phone' => ['required', 'string', 'max:50'],
            
            // Address
            'address_line_1' => ['required', 'string', 'max:255'],
            'address_line_2' => ['nullable', 'string', 'max:255'],
            'country' => ['required', 'string', 'max:2'],
            'city' => ['required', 'string', 'max:255'],
            'state' => ['nullable', 'string', 'max:255'],
            'postal_code' => ['required', 'string', 'max:20'],
            
            // Terms
            'terms' => ['required', 'accepted'],
            'privacy' => ['required', 'accepted'],
        ], [
            // Custom error messages
            'username.required' => 'Please enter a username.',
            'username.unique' => 'This username is already taken.',
            'username.regex' => 'Username can only contain letters, numbers, and underscores.',
            'email.required' => 'Please enter your email address.',
            'email.unique' => 'This email address is already registered.',
            'password.required' => 'Please enter a password.',
            'password.min' => 'Password must be at least 8 characters long.',
            'password.confirmed' => 'Password confirmation does not match.',
            'first_name.required' => 'Please enter your first name.',
            'last_name.required' => 'Please enter your last name.',
            'company_name.required' => 'Please enter your company name.',
            'phone.required' => 'Please enter your phone number.',
            'address_line_1.required' => 'Please enter your address.',
            'country.required' => 'Please select your country.',
            'city.required' => 'Please enter your city.',
            'postal_code.required' => 'Please enter your postal code.',
            'terms.accepted' => 'You must accept the terms and conditions.',
            'privacy.accepted' => 'You must accept the privacy policy.',
        ]);
    }

    /**
     * Create a new user instance after a valid registration
     *
     * @param array $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        // Create full name from first, middle, and last name
        $full_name = trim(implode(' ', array_filter([
            $data['first_name'] ?? '',
            $data['middle_name'] ?? '',
            $data['last_name'] ?? '',
            $data['suffix'] ?? ''
        ])));

        return User::create([
            'name' => $full_name,
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'first_name' => $data['first_name'],
            'middle_name' => $data['middle_name'] ?? null,
            'last_name' => $data['last_name'],
            'suffix' => $data['suffix'] ?? null,
            'company_name' => $data['company_name'],
            'phone_country_code' => $data['phone_country_code'] ?? null,
            'phone' => $data['phone'],
            'address_line_1' => $data['address_line_1'],
            'address_line_2' => $data['address_line_2'] ?? null,
            'country' => $data['country'],
            'city' => $data['city'],
            'state' => $data['state'] ?? null,
            'postal_code' => $data['postal_code'],
            'role' => 'user',
            'terms_accepted' => true,
            'privacy_accepted' => true,
            'terms_accepted_at' => now(),
            'privacy_accepted_at' => now(),
            'email_verified_at' => now(), // Auto-verify email (remove this if you want email verification)
        ]);
    }

    /**
     * Handle AJAX registration request (optional)
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajaxRegister(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $user = $this->create($request->all());
            event(new Registered($user));
            Auth::login($user);

            Log::info('New user registered via AJAX', ['user_id' => $user->id, 'email' => $user->email]);

            return response()->json([
                'success' => true,
                'message' => 'Registration successful!',
                'redirect' => route('user.profile')
            ]);

        } catch (\Exception $e) {
            Log::error('AJAX registration error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Registration failed. Please try again.'
            ], 500);
        }
    }

    /**
     * Check if email is available (for AJAX validation)
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkEmail(Request $request)
    {
        $email = $request->input('email');
        
        if (!$email) {
            return response()->json(['available' => false]);
        }

        $exists = User::where('email', $email)->exists();

        return response()->json([
            'available' => !$exists,
            'message' => $exists ? 'This email is already registered.' : 'Email is available.'
        ]);
    }

    /**
     * Check if username is available (for AJAX validation)
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkUsername(Request $request)
    {
        $username = $request->input('username');
        
        if (!$username) {
            return response()->json(['available' => false]);
        }

        $exists = User::where('username', $username)->exists();

        return response()->json([
            'available' => !$exists,
            'message' => $exists ? 'This username is already taken.' : 'Username is available.'
        ]);
    }

    /**
     * Resend verification email (if using email verification)
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function resendVerification(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('user.profile');
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with('success', 'Verification email has been resent!');
    }
}