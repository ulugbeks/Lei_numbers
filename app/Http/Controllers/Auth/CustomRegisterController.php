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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'terms' => ['required', 'accepted'],
        ], [
            'name.required' => 'Please enter your full name.',
            'email.required' => 'Please enter your email address.',
            'email.unique' => 'This email address is already registered.',
            'password.required' => 'Please enter a password.',
            'password.min' => 'Password must be at least 8 characters long.',
            'password.confirmed' => 'Password confirmation does not match.',
            'terms.accepted' => 'You must accept the terms and conditions.',
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
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
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