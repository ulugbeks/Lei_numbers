@extends('layouts.app')

@section('title', 'Home')

@section('content')

@include('partials.header')

<!-- main-area -->
<main class="fix">

<section class="pricing-area">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-10">
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
                                    <!-- <div class="plan-features">
                                        <ul>
                                            <li><i class="fas fa-check"></i> Annual registration</li>
                                            <li><i class="fas fa-check"></i> Standard support</li>
                                        </ul>
                                    </div> -->
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
                                    <!-- <div class="plan-features">
                                        <ul>
                                            <li><i class="fas fa-check"></i> 3-year registration</li>
                                            <li><i class="fas fa-check"></i> Priority support</li>
                                        </ul>
                                    </div> -->
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
                                    <!-- <div class="plan-features">
                                        <ul>
                                            <li><i class="fas fa-check"></i> 5-year registration</li>
                                            <li><i class="fas fa-check"></i> Premium support</li>
                                        </ul>
                                    </div> -->
                                    <div class="plan-total">Total €250</div>
                                    <button class="plan-select-btn">Select Plan</button>
                                </div>
                            </div>
                            
                            <div class="step-navigation single">
                                <button class="next-step-btn" data-goto="2">Continue to Form <i class="fas fa-arrow-right"></i></button>
                            </div>
                        </div>
                        
                        <div class="step-section" id="step-2">
                            <div class="step-header">
                                <h3 class="step-title">Complete the form</h3>
                                <p class="step-description">Start typing, and let us fill all the relevant details for you.</p>
                            </div>
                            
                            <form id="register-form" action="{{ route('contact.store') }}" method="POST">
                                @csrf
                                <div class="form-section">
                                    <h4 class="form-section-title">Company Information</h4>
                                    
                                    <div class="row">
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
                                                <label for="full_name">Applicant's full name <span class="required">*</span></label>
                                                <div class="input-with-icon">
                                                    <i class="fas fa-user"></i>
                                                    <input type="text" id="full_name" name="full_name" class="form-control" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="legal_entity_name">Legal entity name <span class="required">*</span></label>
                                                <div class="input-with-icon">
                                                    <i class="fas fa-building"></i>
                                                    <input type="text" id="legal_entity_name" name="legal_entity_name" class="form-control" required>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="registration_id">Registration ID <span class="required">*</span></label>
                                                <div class="input-with-icon">
                                                    <i class="fas fa-id-card"></i>
                                                    <input type="text" id="registration_id" name="registration_id" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-section">
                                    <h4 class="form-section-title">Contact Information</h4>
                                    
                                    <div class="row">
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
                                                <label for="phone">Phone Number <span class="required">*</span></label>
                                                <div class="input-with-icon">
                                                    <i class="fas fa-phone"></i>
                                                    <input type="tel" id="phone" name="phone" class="form-control" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row" style="display: none;">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <p class="upload-instruction">To verify announcement, please upload a document listing the legal entity's authorized representatives (e.g., board meeting minutes, articles of association):</p>
                                                <div class="upload-area">
                                                    <div class="upload-icon"><i class="fa fa-upload"></i></div>
                                                    <div class="upload-text">Browse files or drag and drop</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-section">
                                    <h4 class="form-section-title">Address Information</h4>
                                    
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="address">Office, building, street <span class="required">*</span></label>
                                                <div class="input-with-icon">
                                                    <i class="fas fa-map-marker-alt"></i>
                                                    <input type="text" id="address" name="address" class="form-control" required>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="city">City, state <span class="required">*</span></label>
                                                <div class="input-with-icon">
                                                    <i class="fas fa-city"></i>
                                                    <input type="text" id="city" name="city" class="form-control" required>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="zip_code">Post code <span class="required">*</span></label>
                                                <div class="input-with-icon">
                                                    <i class="fas fa-map-pin"></i>
                                                    <input type="text" id="zip_code" name="zip_code" class="form-control" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="toggle-switch-group">
                                                <span class="toggle-label">Headquarters address is identical to legal address?</span>
                                                <label class="toggle-switch">
                                                    <input type="checkbox" name="same_address" id="same_address">
                                                    <span class="toggle-slider"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    
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
                                </div>
                                
                                <div class="form-section">
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
                        <div class="step-section">
                            <div class="step-header">
                                <h3 class="step-title">Renew your LEI</h3>
                                <p class="step-description">Enter your LEI code or company name to quickly renew your registration.</p>
                            </div>
                            
                            <form id="renew-form" action="{{ url('/renew-submit') }}" method="POST">
                                @csrf
                                <div class="form-section">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="lei">Insert LEI or company name <span class="required">*</span></label>
                                                <div class="input-with-icon">
                                                    <i class="fas fa-search"></i>
                                                    <input type="text" id="lei" name="lei" class="form-control" placeholder="Enter LEI code or company name" required>
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
                    
                    <div id="transfer" class="tab-content">
                        <div class="step-section">
                            <div class="step-header">
                                <h3 class="step-title">Transfer your LEI</h3>
                                <p class="step-description">Transfer your existing LEI to our service for better rates and support.</p>
                            </div>
                            
                            <form id="transfer-form" action="{{ url('/transfer-submit') }}" method="POST">
                                @csrf
                                <div class="form-section">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="transfer-lei">LEI Code to Transfer <span class="required">*</span></label>
                                                <div class="input-with-icon">
                                                    <i class="fas fa-exchange-alt"></i>
                                                    <input type="text" id="transfer-lei" name="lei" class="form-control" placeholder="Enter LEI code to transfer" required>
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
                </div>
            </div>
        </div>
    </div>
</section>


</main>
<!-- main-area-end -->

@include('partials.footer')

@endsection
