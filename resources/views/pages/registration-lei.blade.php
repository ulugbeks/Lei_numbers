@extends('layouts.app')

@section('title', 'Home')

@section('content')

@include('partials.header')

<!-- main-area -->
<main class="fix">

@php
    $page = App\Models\Page::where('slug', 'registration-lei')->first();
    $content = json_decode($page->content ?? '{}', true);
    $service = $content['service_header'] ?? [];
    $plans = $content['plans'] ?? [];
    $form = $content['form'] ?? [];
    $tabs = $content['tabs'] ?? [];
@endphp

<!-- Add LEI Lookup Tool section -->
    <section class="lei-lookup-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-12">
                    <div class="service-header">
                        <h2>LEI Lookup Tool</h2>
                        <p>Verify and access information about any Legal Entity Identifier</p>
                    </div>
                    
                    <div class="lei-lookup-container">
                        <div class="lookup-form">
                            <div class="form-group">
                                <label for="lookup-query">Enter LEI Code or Company Name</label>
                                <div class="search-input-container">
                                    <div class="input-with-icon">
                                        <i class="fas fa-search"></i>
                                        <input type="text" id="lookup-query" class="form-control" placeholder="20-character LEI code or company name">
                                    </div>
                                    <button type="button" id="lookup-btn" class="search-btn">
                                        <i class="fas fa-search"></i> Lookup
                                    </button>
                                </div>
                            </div>
                        </div>
                        
                        <div id="lookup-results" class="lookup-results">
                            <!-- Results will be displayed here by the GLEIF integration -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="pricing-area">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-12">
                    <div class="service-header">
                        <h2>LEI Register Services</h2>
                        <p>Secure your Legal Entity Identifier with our trusted registration service</p>
                    </div>
                    
                    <div class="pricing-item-wrap">
                        <div class="tabs-container">
                            <div class="tab-buttons">
                                <button class="tab-btn active" data-tab="register">
                                    <i class="fas fa-user-plus"></i> REGISTER
                                </button>
                                <button class="tab-btn" data-tab="renew">
                                    <i class="fas fa-sync"></i> RENEW
                                </button>
                                <button class="tab-btn" data-tab="transfer">
                                    <i class="fas fa-exchange-alt"></i> TRANSFER
                                </button>
                                <!-- New Bulk tab button -->
                                <button class="tab-btn" data-tab="bulk">
                                    <i class="fas fa-th-large"></i> BULK
                                </button>
                            </div>
                        </div>
                        
                        <div id="register" class="tab-content active">
                            <div class="progress-bar-container">
                                <div class="progress-steps">
                                    <div class="progress-step active" data-step="1">
                                        <div class="step-icon"><i class="fas fa-check"></i></div>
                                        <div class="step-label">Plan</div>
                                    </div>
                                    <div class="progress-connector"></div>
                                    <div class="progress-step" data-step="2">
                                        <div class="step-icon">2</div>
                                        <div class="step-label">Details</div>
                                    </div>
                                    <div class="progress-connector"></div>
                                    <div class="progress-step" data-step="3">
                                        <div class="step-icon">3</div>
                                        <div class="step-label">Payment</div>
                                    </div>
                                </div>
                            </div>

                            <div class="step-section active" id="step-1">
                                <div class="step-header">
                                    <h3 class="step-title">Select a plan</h3>
                                    <p class="step-description">Save money on each annual renewal based on multi-year plans.</p>
                                </div>
                                
                                <div class="plans-container">
                                    <div class="plan-card" data-plan="1-year">
                                        <div class="plan-header">
                                            <h4 class="plan-title">1 year</h4>
                                        </div>
                                        <div class="plan-price">
                                            <span class="currency">€</span>75
                                            <span class="period">/ year</span>
                                        </div>
                                        <div class="plan-total">Total €75</div>
                                        <button class="plan-select-btn">Select Plan</button>
                                    </div>
                                    
                                    <div class="plan-card selected" data-plan="3-years">
                                        <div class="popular-badge">Most popular</div>
                                        <div class="plan-header">
                                            <h4 class="plan-title">3 years</h4>
                                        </div>
                                        <div class="plan-price">
                                            <span class="currency">€</span>55
                                            <span class="period">/ year</span>
                                        </div>
                                        <div class="plan-total">Total €165</div>
                                        <button class="plan-select-btn">Select Plan</button>
                                    </div>
                                    
                                    <div class="plan-card" data-plan="5-years">
                                        <div class="plan-header">
                                            <h4 class="plan-title">5 years</h4>
                                        </div>
                                        <div class="plan-price">
                                            <span class="currency">€</span>50
                                            <span class="period">/ year</span>
                                        </div>
                                        <div class="plan-total">Total €250</div>
                                        <button class="plan-select-btn">Select Plan</button>
                                    </div>
                                </div>
                                
                                <div class="step-navigation">
                                    <button class="next-step-btn" data-goto="2">Continue to Form <i class="fas fa-arrow-right"></i></button>
                                </div>
                            </div>
                            
                            <div class="step-section" id="step-2">
                                <div class="step-header">
                                    <h3 class="step-title">Complete the form</h3>
                                    
                                </div>
                                
                                <form id="register-form" action="{{ route('register.submit') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="selected_plan" id="selected_plan" value="3-years">

                                    <div class="form-section">
                                        <h4 class="form-section-title">Company Information</h4>

                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="legal_entity_name">Legal entity name <span class="required">*</span></label>
                                                    <div class="input-with-icon">
                                                        <i class="fas fa-building"></i>
                                                        <input type="text" id="legal_entity_name" name="legal_entity_name" class="form-control" required>
                                                        <!-- Auto-complete results will appear here -->
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="registration_id">Registration number <span class="required">*</span></label>
                                                    <div class="input-with-icon">
                                                        <i class="fas fa-id-card"></i>
                                                        <input type="text" id="registration_id" name="registration_id" class="form-control">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="phone">Phone Number <span class="required">*</span></label>
                                                    <div class="input-with-icon">
                                                        <i class="fas fa-phone"></i>
                                                        <input type="tel" id="phone" name="phone" class="form-control">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="email">Email <span class="required">*</span></label>
                                                    <div class="input-with-icon">
                                                        <i class="fas fa-envelope"></i>
                                                        <input type="email" id="email" name="email" class="form-control" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="full_name">Applicant's first name <span class="required">*</span></label>
                                                    <div class="input-with-icon">
                                                        <i class="fas fa-user"></i>
                                                        <input type="text" id="full_name" name="full_name" class="form-control" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="full_name">Applicant's last name <span class="required">*</span></label>
                                                    <div class="input-with-icon">
                                                        <i class="fas fa-user"></i>
                                                        <input type="text" id="full_name" name="full_name" class="form-control" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="country">Country <span class="required">*</span></label>
                                                    <div class="input-with-icon">
                                                        <i class="fas fa-globe"></i>
                                                        <select name="country" id="country" class="form-control select2" required>
                                                            <option value="" disabled selected>Select Your Country...</option>
                                                            @foreach (config('countries') as $code => $name)
                                                            <option value="{{ $code }}" data-code="{{ strtolower($code) }}">{{ $name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="address">Address <span class="required">*</span></label>
                                                    <div class="input-with-icon">
                                                        <i class="fas fa-map-marker-alt"></i>
                                                        <input type="text" id="address" name="address" class="form-control" placeholder="Building, street, office" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="address">Address 2</label>
                                                    <div class="input-with-icon">
                                                        <i class="fas fa-map-marker-alt"></i>
                                                        <input type="text" id="address2" name="address2" class="form-control" placeholder="Optional">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="city">City <span class="required">*</span></label>
                                                    <div class="input-with-icon">
                                                        <i class="fas fa-city"></i>
                                                        <input type="text" id="city" name="city" class="form-control" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="city">State <span class="required">*</span></label>
                                                    <div class="input-with-icon">
                                                        <i class="fas fa-city"></i>
                                                        <input type="text" id="city" name="city" class="form-control" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="zip_code">Post code / ZIP <span class="required">*</span></label>
                                                    <div class="input-with-icon">
                                                        <i class="fas fa-map-pin"></i>
                                                        <input type="text" id="zip_code" name="zip_code" class="form-control" required>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>

                                    <div class="form-section">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="toggle-switch-group">
                                                    <span class="toggle-label">Headquarters address is identical to legal address?</span>
                                                    <label class="toggle-switch">
                                                        <input type="checkbox" name="same_address" id="same_address" checked>
                                                        <span class="toggle-slider"></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Headquarters address fields will be dynamically added here when toggle is unchecked -->

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="toggle-switch-group">
                                                    <span class="toggle-label">Is the legal entity solely controlled by private individuals (natural persons)?</span>
                                                    <label class="toggle-switch">
                                                        <input type="checkbox" name="private_controlled" id="private_controlled">
                                                        <span class="toggle-slider"></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="terms-checkbox">
                                                    <input type="checkbox" id="terms" name="terms" required>
                                                    <label for="terms">
                                                        I accept LEI Register's <a href="#">Terms & Conditions</a> and <a href="#">Privacy Policy</a> <span class="required">*</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="step-navigation">
                                        <button type="button" class="prev-step-btn" data-goto="1"><i class="fas fa-arrow-left"></i> Back to Plans</button>
                                        <button type="submit" class="submit-btn">CONFIRM & CONTINUE</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        
                        <div id="renew" class="tab-content">
                            <div class="step-section active">
                                <div class="step-header">
                                    <h3 class="step-title">Renew your LEI</h3>
                                    <p class="step-description">Enter your LEI code or company name to quickly renew your registration.</p>
                                </div>
                                
                                <form id="renew-form" action="{{ route('renew.submit') }}" method="POST">
                                    @csrf
                                    <div class="form-section">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="lei">Insert LEI or company name <span class="required">*</span></label>
                                                    <div class="search-input-container">
                                                        <div class="input-with-icon">
                                                            <i class="fas fa-search"></i>
                                                            <input type="text" id="lei" name="lei" class="form-control" placeholder="Enter LEI code or company name" required>
                                                        </div>
                                                        <button type="button" class="search-btn">
                                                            <i class="fas fa-search"></i> Search
                                                        </button>
                                                    </div>
                                                    <div class="form-text">
                                                        You can search by LEI code (20 characters) or by company name
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Results will be displayed here by the GLEIF integration -->
                                    <div class="lei-search-results" style="display: none;"></div>
                                    
                                    <div class="step-navigation justify-content-center">
                                        <button type="submit" class="submit-btn">CONFIRM & CONTINUE</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        
                        <div id="transfer" class="tab-content">
                            <div class="step-section active">
                                <div class="step-header">
                                    <h3 class="step-title">Transfer your LEI</h3>
                                    <p class="step-description">Transfer your existing LEI to our service for better rates and support.</p>
                                </div>
                                
                                <form id="transfer-form" action="{{ route('transfer.submit') }}" method="POST">
                                    @csrf
                                    <div class="form-section">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="transfer-lei">LEI Code to Transfer <span class="required">*</span></label>
                                                    <div class="search-input-container">
                                                        <div class="input-with-icon">
                                                            <i class="fas fa-exchange-alt"></i>
                                                            <input type="text" id="transfer-lei" name="lei" class="form-control" placeholder="Enter LEI code to transfer" required>
                                                        </div>
                                                        <button type="button" class="search-btn verify-lei-btn">
                                                            <i class="fas fa-check"></i> Verify LEI
                                                        </button>
                                                    </div>
                                                    <div class="form-text">
                                                        Enter your current LEI code (20 characters) to transfer to our service
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- LEI verification results will appear here -->
                                        <div class="lei-verification-results" style="display: none;"></div>
                                        
                                        <!-- Transfer details will only show after verification -->
                                        <div class="transfer-details" style="display: none;">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="transfer-reason">Reason for Transfer <span class="required">*</span></label>
                                                        <select id="transfer-reason" name="transfer_reason" class="form-control" required>
                                                            <option value="" disabled selected>Select reason for transfer...</option>
                                                            <option value="better_price">Better Price</option>
                                                            <option value="better_service">Better Service</option>
                                                            <option value="current_issues">Issues with Current Provider</option>
                                                            <option value="company_policy">Company Policy</option>
                                                            <option value="other">Other</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="transfer-email">Contact Email <span class="required">*</span></label>
                                                        <div class="input-with-icon">
                                                            <i class="fas fa-envelope"></i>
                                                            <input type="email" id="transfer-email" name="email" class="form-control" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="step-navigation justify-content-center">
                                        <button type="submit" class="submit-btn">CONFIRM & CONTINUE</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        
                        <!-- Bulk tab content -->
                        <div id="bulk" class="tab-content">
                            <div class="step-section active">
                                <div class="step-header">
                                    <h3 class="step-title">Bulk LEI Registration</h3>
                                    <p class="step-description">Register multiple LEIs at once for your organization.</p>
                                </div>
                                
                                <div class="step-navigation justify-content-center">
                                    <button type="button" class="submit-btn open-popup-btn" id="open-bulk-popup">START BULK REGISTRATION</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Popup for Bulk Registration -->
    <div class="popup-overlay" id="bulk-popup-overlay">
        <div class="popup-container">
            <div class="popup-header">
                <h3>Bulk LEI Registration</h3>
                <button type="button" class="close-popup-btn" id="close-bulk-popup">&times;</button>
            </div>
            <div class="popup-content">
                <div class="contact-form">
                    <form id="bulk-register-form" action="{{ route('bulk.submit') }}" method="POST" class="register-form">
                        @csrf
                        <div class="row">
                            <!-- First Name -->
                            <div class="col-md-6">
                                <div class="form-grp">
                                    <input type="text" name="first_name" placeholder="First Name *" required>
                                </div>
                            </div>
                            <!-- Last Name -->
                            <div class="col-md-6">
                                <div class="form-grp">
                                    <input type="text" name="last_name" placeholder="Last Name *" required>
                                </div>
                            </div>
                            <!-- Company Name -->
                            <div class="col-md-12">
                                <div class="form-grp">
                                    <input type="text" name="company_name" placeholder="Company Name *">
                                </div>
                            </div>
                            <!-- Country -->
                            <div class="col-md-12">
                                <div class="form-grp">
                                    <div class="input-with-icon">
                                        <i class="fas fa-globe"></i>
                                        <select name="country" id="country" class="form-control select2" required>
                                            <option value="" disabled selected>Select Your Country...</option>
                                            @foreach (config('countries') as $code => $name)
                                            <option value="{{ $code }}" data-code="{{ strtolower($code) }}">{{ $name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <!-- Email -->
                            <div class="col-md-6">
                                <div class="form-grp">
                                    <input type="email" name="email" placeholder="E-mail *" required>
                                </div>
                            </div>
                            <!-- Phone -->
                            <div class="col-md-6">
                                <div class="form-grp">
                                    <input type="tel" name="phone" id="phone" placeholder="Phone number *" class="form-control-custom">
                                </div>
                            </div>
                            <!-- Agreement Checkbox -->
                            <div class="col-md-12">
                                <div class="">
                                    <div class="terms-checkbox">
                                        <input type="checkbox" id="bulk-terms" name="terms" required>
                                        <label for="bulk-terms">
                                            I accept LEI Register's <a href="#">Terms &amp; Conditions</a> and <a href="#">Privacy Policy</a> <span class="required">*</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit">Submit Now</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

<!-- Additional content if needed -->
{!! $content['main_content'] ?? '' !!}

<!-- FAQ Section if available -->
@if(isset($content['faqs']) && count($content['faqs']) > 0)
<section class="faq-area">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="section-title text-center mb-60">
                    <h2>Frequently Asked Questions</h2>
                    <p>Find answers to common questions about LEI registration</p>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="accordion" id="faqAccordion">
                    @foreach($content['faqs'] as $index => $faq)
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="faqHeading{{ $index }}">
                            <button class="accordion-button {{ $index > 0 ? 'collapsed' : '' }}" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse{{ $index }}" aria-expanded="{{ $index === 0 ? 'true' : 'false' }}" aria-controls="faqCollapse{{ $index }}">
                                {{ $faq['question'] }}
                            </button>
                        </h2>
                        <div id="faqCollapse{{ $index }}" class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}" aria-labelledby="faqHeading{{ $index }}" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">
                                {!! $faq['answer'] !!}
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@endif

</main>
<!-- main-area-end -->

@include('partials.footer')

@endsection