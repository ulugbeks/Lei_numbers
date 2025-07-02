<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\ThrottlesLogins;

class CustomLoginController extends Controller
{
    use ThrottlesLogins;

    /**
     * Maximum login attempts
     */
    protected $maxAttempts = 5;
    
    /**
     * Lockout time in minutes
     */
    protected $decayMinutes = 15;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Show the login form
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('auth.custom-login');
    }

    /**
     * Handle login request
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        // Validate the form data
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->only('email', 'remember'));
        }

        // Check if the user has too many login attempts
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);
            return $this->sendLockoutResponse($request);
        }

        // Attempt to log the user in
        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            // Authentication passed
            $request->session()->regenerate();
            $this->clearLoginAttempts($request);

            // Check if user is admin (you can modify this logic)
            $user = Auth::user();
            
            // Log the successful login (optional - using Laravel's built-in logging)
            \Log::info('User logged in', ['user_id' => $user->id, 'email' => $user->email]);

            // Redirect based on user type
            if ($this->isAdmin($user)) {
                return redirect()->intended('/backend');
            }

            // Check if there's an intended URL (where user was trying to go)
            if (session()->has('url.intended')) {
                return redirect()->intended();
            }

            // Default redirect to user profile
            return redirect()->route('user.profile');
        }

        // If unsuccessful, increment login attempts
        $this->incrementLoginAttempts($request);

        // Authentication failed
        return redirect()->back()
            ->withErrors([
                'email' => 'These credentials do not match our records.',
            ])
            ->withInput($request->only('email', 'remember'));
    }

    /**
     * Log the user out
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        // Log the logout action
        if (Auth::check()) {
            \Log::info('User logged out', ['user_id' => Auth::id(), 'email' => Auth::user()->email]);
        }

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'You have been successfully logged out.');
    }

    /**
     * Get the login username to be used by the controller
     *
     * @return string
     */
    public function username()
    {
        return 'email';
    }

    /**
     * Check if user is admin
     *
     * @param \App\Models\User $user
     * @return bool
     */
    protected function isAdmin($user)
    {
        // You can implement your own admin check logic here
        // For example, check if email matches admin emails
        $adminEmails = [
            'admin@lei-register.co.uk',
            'admin@example.com'
        ];

        return in_array($user->email, $adminEmails);
        
        // Or check if user has admin role (if you have roles)
        // return $user->hasRole('admin');
        
        // Or check if user has is_admin column
        // return $user->is_admin;
    }

    /**
     * Redirect the user after determining they are locked out
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendLockoutResponse(Request $request)
    {
        $seconds = $this->limiter()->availableIn(
            $this->throttleKey($request)
        );

        $minutes = ceil($seconds / 60);

        return redirect()->back()
            ->withInput($request->only($this->username(), 'remember'))
            ->withErrors([
                $this->username() => 'Too many login attempts. Please try again in ' . $minutes . ' minutes.',
            ]);
    }

    /**
     * Get the throttle key for the given request
     *
     * @param \Illuminate\Http\Request $request
     * @return string
     */
    protected function throttleKey(Request $request)
    {
        return strtolower($request->input($this->username())) . '|' . $request->ip();
    }
}