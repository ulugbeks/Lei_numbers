<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\ThrottlesLogins;

class AdminLoginController extends Controller
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
     * Show the admin login form
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    /**
     * Handle admin login request
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

            $user = Auth::user();
            
            // Check if user is admin
            if (!$user->isAdmin()) {
                Auth::logout();
                return redirect()->route('admin.login')
                    ->withErrors(['email' => 'Access denied. Admin privileges required.']);
            }
            
            // Log the successful admin login
            \Log::info('Admin logged in', ['user_id' => $user->id, 'email' => $user->email]);

            // Redirect to admin dashboard
            return redirect()->intended(route('admin.dashboard'));
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
     * Log the admin out
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        // Log the logout action
        if (Auth::check()) {
            \Log::info('Admin logged out', ['user_id' => Auth::id(), 'email' => Auth::user()->email]);
        }

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')->with('success', 'You have been successfully logged out.');
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
        return 'admin_' . strtolower($request->input($this->username())) . '|' . $request->ip();
    }
}