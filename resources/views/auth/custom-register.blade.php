@extends('layouts.app')

@section('title', 'Sign Up')

@section('content')

@include('partials.header')

<main class="fix">
    <!-- breadcrumb-area -->
    <section class="breadcrumb-area breadcrumb-bg" data-background="{{ asset('assets/img/bg/breadcrumb_bg.jpg') }}">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-content">
                        <h2 class="title">Sign Up</h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Sign Up</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- breadcrumb-area-end -->

    <!-- register-area -->
    <section class="register-area section-py-120">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="register-form-wrap">
                        <h3 class="title text-center mb-4">Create Your Account</h3>
                        
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('register') }}" method="POST" class="register-form" id="registration-form">
                            @csrf
                            
                            <!-- Account Information Section -->
                            <div class="form-section mb-4">
                                <h4 class="section-title">Account Info</h4>
                                
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-grp">
                                            <label for="username">Username <span class="required">*</span></label>
                                            <input type="text" id="username" name="username" placeholder="Username" value="{{ old('username') }}" required>
                                            @error('username')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-grp">
                                            <label for="password">Password <span class="required">*</span></label>
                                            <input type="password" id="password" name="password" placeholder="Password" required>
                                            @error('password')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-grp">
                                            <label for="password_confirmation">Repeat Password <span class="required">*</span></label>
                                            <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Repeat Password" required>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-12">
                                        <div class="form-grp">
                                            <label for="email">Email <span class="required">*</span></label>
                                            <input type="email" id="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
                                            @error('email')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- User Details Section -->
                            <div class="form-section mb-4">
                                <h4 class="section-title">User Details</h4>
                                
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-grp">
                                            <label for="first_name">First Name <span class="required">*</span></label>
                                            <input type="text" id="first_name" name="first_name" placeholder="First Name" value="{{ old('first_name') }}" required>
                                            @error('first_name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-2">
                                        <div class="form-grp">
                                            <label for="middle_name">Middle Name</label>
                                            <input type="text" id="middle_name" name="middle_name" placeholder="M" value="{{ old('middle_name') }}">
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-5">
                                        <div class="form-grp">
                                            <label for="last_name">Last Name <span class="required">*</span></label>
                                            <input type="text" id="last_name" name="last_name" placeholder="Last Name" value="{{ old('last_name') }}" required>
                                            @error('last_name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-2">
                                        <div class="form-grp">
                                            <label for="suffix">Suffix</label>
                                            <input type="text" id="suffix" name="suffix" placeholder="Suffix" value="{{ old('suffix') }}">
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-12">
                                        <div class="form-grp">
                                            <label for="company_name">Company Name <span class="required">*</span></label>
                                            <input type="text" id="company_name" name="company_name" placeholder="Company Name" value="{{ old('company_name') }}" required>
                                            @error('company_name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-3">
                                        <div class="form-grp">
                                            <label for="phone_country_code">Phone Country Code</label>
                                            <select name="phone_country_code" id="phone_country_code" class="form-control">
                                                <option value="">Country Code</option>
                                                <option value="+1" {{ old('phone_country_code') == '+1' ? 'selected' : '' }}>+1 (US)</option>
                                                <option value="+44" {{ old('phone_country_code') == '+44' ? 'selected' : '' }}>+44 (UK)</option>
                                                <option value="+49" {{ old('phone_country_code') == '+49' ? 'selected' : '' }}>+49 (DE)</option>
                                                <option value="+33" {{ old('phone_country_code') == '+33' ? 'selected' : '' }}>+33 (FR)</option>
                                                <option value="+371" {{ old('phone_country_code') == '+371' ? 'selected' : '' }}>+371 (LV)</option>
                                                <!-- Add more country codes as needed -->
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-9">
                                        <div class="form-grp">
                                            <label for="phone">Phone <span class="required">*</span></label>
                                            <input type="tel" id="phone" name="phone" placeholder="Phone" value="{{ old('phone') }}" required>
                                            @error('phone')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Address Section -->
                            <div class="form-section mb-4">
                                <h4 class="section-title">Address</h4>
                                
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-grp">
                                            <label for="address_line_1">Address Line 1 <span class="required">*</span></label>
                                            <input type="text" id="address_line_1" name="address_line_1" placeholder="Address Line 1" value="{{ old('address_line_1') }}" required>
                                            @error('address_line_1')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-12">
                                        <div class="form-grp">
                                            <label for="address_line_2">Address Line 2</label>
                                            <input type="text" id="address_line_2" name="address_line_2" placeholder="Address Line 2" value="{{ old('address_line_2') }}">
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-12">
                                        <div class="form-grp">
                                            <label for="country">Country/Region <span class="required">*</span></label>
                                            <select name="country" id="country" class="form-control select2" required>
                                                <option value="">Country/Region</option>
                                                @foreach (config('countries') as $code => $name)
                                                    <option value="{{ $code }}" {{ old('country') == $code ? 'selected' : '' }}>{{ $name }}</option>
                                                @endforeach
                                            </select>
                                            @error('country')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-grp">
                                            <label for="city">City <span class="required">*</span></label>
                                            <input type="text" id="city" name="city" placeholder="City" value="{{ old('city') }}" required>
                                            @error('city')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-grp">
                                            <label for="state">State</label>
                                            <input type="text" id="state" name="state" placeholder="State" value="{{ old('state') }}">
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-12">
                                        <div class="form-grp">
                                            <label for="postal_code">Postal Code <span class="required">*</span></label>
                                            <input type="text" id="postal_code" name="postal_code" placeholder="Postal Code" value="{{ old('postal_code') }}" required>
                                            @error('postal_code')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Terms and Policy Section -->
                            <div class="form-section mb-4">
                                <h4 class="section-title">Terms and Policy</h4>
                                
                                <div class="terms-checkboxes">
                                    <div class="form-check mb-3">
                                        <input type="checkbox" class="form-check-input" id="terms" name="terms" value="1" {{ old('terms') ? 'checked' : '' }} required>
                                        <label class="form-check-label" for="terms">
                                            I have read and agree to the <a href="{{ route('terms-and-conditions') }}" target="_blank">Terms of Service</a>. <span class="required">*</span>
                                        </label>
                                        @error('terms')
                                            <span class="text-danger d-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="privacy" name="privacy" value="1" {{ old('privacy') ? 'checked' : '' }} required>
                                        <label class="form-check-label" for="privacy">
                                            I have read and agree to the <a href="{{ route('privacy-policy') }}" target="_blank">Privacy Policy</a>. <span class="required">*</span>
                                        </label>
                                        @error('privacy')
                                            <span class="text-danger d-block">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-primary btn-lg">Sign Up</button>
                            </div>
                            
                            <div class="text-center mt-3">
                                Already have an account? <a href="{{ route('login') }}">Sign In</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- register-area-end -->
</main>

@include('partials.footer')

<style>
.register-form-wrap {
    background: #fff;
    padding: 40px;
    border-radius: 10px;
    box-shadow: 0 0 20px rgba(0,0,0,0.1);
}

.form-section {
    border-bottom: 1px solid #eee;
    padding-bottom: 20px;
}

.section-title {
    font-size: 18px;
    font-weight: 600;
    margin-bottom: 20px;
    color: #333;
}

.form-grp {
    margin-bottom: 20px;
}

.form-grp label {
    display: block;
    margin-bottom: 5px;
    font-weight: 500;
    color: #666;
}

.form-grp input,
.form-grp select {
    width: 100%;
    padding: 10px 15px;
    border: 1px solid #ddd;
    border-radius: 5px;
    transition: border-color 0.3s;
}

.form-grp input:focus,
.form-grp select:focus {
    outline: none;
    border-color: #007bff;
}

.required {
    color: #dc3545;
}

.text-danger {
    font-size: 14px;
    margin-top: 5px;
}

.terms-checkboxes {
    padding: 20px;
    background: #f8f9fa;
    border-radius: 5px;
}

.form-check-input {
    margin-top: 0.3rem;
}

.form-check-label {
    margin-left: 5px;
}
</style>

@endsection