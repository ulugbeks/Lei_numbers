@extends('layouts.app')

@section('title', 'Home')

@section('content')

@include('partials.header')

<!-- main-area -->
<main class="fix">

	@php
	    $page = App\Models\Page::where('slug', 'home')->first();
	    $content = json_decode($page->content, true);
	    $banner = $content['banner'] ?? [];
	    $features = $content['features'] ?? [];
	    $about = $content['about'] ?? [];
	    $request = $content['request'] ?? [];
	@endphp

	<!-- banner-area -->
	<section class="banner-area-two banner-bg-two" data-background="{{ isset($banner['background_image']) ? asset('storage/' . $banner['background_image']) : 'assets/img/banner/home-bg-.jpg' }}">
	    <div class="container">
	        <div class="row align-items-center">
	            <div class="col-lg-8">
	                <div class="banner-content-two">
	                    <h1 class="title" data-aos="fade-up" data-aos-delay="300" style="color: #fff">{{ $banner['title'] ?? 'Apply for an LEI number' }}</h1>
	                    <p data-aos="fade-up" data-aos-delay="500" style="color: #fff">{!! preg_replace('/<\/?p>/', '', $banner['description'] ?? '') !!}</p>
	                    <div class="banner-btn">
	                        <a href="{{ $banner['button_url'] ?? '/about-lei' }}" class="btn" data-aos="fade-right" data-aos-delay="700">{{ $banner['button_text'] ?? 'What is LEI' }}</a>
	                    </div>
	                </div>
	            </div>
	            <div class="col-lg-4 mob">
	                <div class="banner-img text-center">
	                    <img src="assets/img/gleif.svg" alt="" data-aos="fade-left" data-aos-delay="400">
	                </div>
	            </div>
	        </div>
	    </div>
	    <div class="banner-shape-wrap">
	        <!-- <img src="assets/img/banner/h2_banner_shape01.png" alt="">
	        <img src="assets/img/banner/h2_banner_shape02.png" alt=""> -->
	        <!-- <img src="assets/img/banner/h2_banner_shape03.png" alt="" data-aos="zoom-in-up" data-aos-delay="800"> -->
	    </div>
	</section>
	<!-- banner-area-end -->

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

		<!-- features-area -->
		<section class="features-area section-py-120">
			<div class="container">
				<div class="row justify-content-center">
					@forelse($features as $feature)
    					<div class="col-lg-4 col-md-4">
    						<div class="features-item">
    							<div class="features-content">
    								<div class="content-top">
    									<div class="icon">
    										<i class="flaticon-puzzle-piece"></i>
    									</div>
    									<h2 class="title">{{ $feature['title'] ?? 'Feature Title' }}</h2>
    								</div>
    								<p>{!! preg_replace('/<\/?p>/', '', $feature['description'] ?? 'Feature description goes here.') !!}</p>
    							</div>
    						</div>
    					</div>
					@empty
    					<!-- Default features if none are defined -->
    					<div class="col-lg-4 col-md-6">
    						<div class="features-item">
    							<div class="features-content">
    								<div class="content-top">
    									<div class="icon">
    										<i class="flaticon-puzzle-piece"></i>
    									</div>
    									<h2 class="title">Register LEI</h2>
    								</div>
    								<p>Register LEI on our portal in a few seconds</p>
    							</div>
    						</div>
    					</div>
    					<div class="col-lg-4 col-md-6">
    						<div class="features-item">
    							<div class="features-content">
    								<div class="content-top">
    									<div class="icon">
    										<i class="flaticon-inspiration"></i>
    									</div>
    									<h2 class="title">Easy LEI application</h2>
    								</div>
    								<p>Through the connection to more than 20 national commercial registers, your company data can be imported directly</p>
    							</div>
    						</div>
    					</div>
    					<div class="col-lg-4 col-md-6">
    						<div class="features-item">
    							<div class="features-content">
    								<div class="content-top">
    									<div class="icon">
    										<i class="flaticon-profit"></i>
    									</div>
    									<h2 class="title">Allocation within 2 hours</h2>
    								</div>
    								<p>LEI verification by our staff and transmission to the central GLEIF database</p>
    							</div>
    						</div>
    					</div>
					@endforelse
				</div>
			</div>
		</section>
		<!-- features-area-end -->

		<!-- about-area -->
		<section class="about-area about-bg" data-background="assets/img/bg/about_bg.jpg">
			<div class="container">
				<div class="row align-items-center">
					<div class="col-lg-5">
						<div class="about-img-wrap">
							<img src="{{ isset($about['image']) ? asset('storage/' . $about['image']) : 'assets/img/images/about_img01.png' }}" alt="" class="main-img">
							<img src="assets/img/images/about_img_shape01.png" alt="">
							<img src="assets/img/images/about_img_shape02.png" alt="">
						</div>
					</div>
					<div class="col-lg-7">
						<div class="about-content">
							<div class="section-title mb-25 tg-heading-subheading animation-style2">
								<span class="sub-title tg-element-title">{{ $about['subtitle'] ?? 'What We are Doing' }}</span>
								<h2 class="title tg-element-title">{{ $about['title'] ?? 'Changing The Way To Do Best Business Solutions' }}</h2>
							</div>
							<p>{!! preg_replace('/<\/?p>/', '', $about['description'] ?? 'Borem ipsum dolor sit amet, consectetur adipiscing elita floraipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod temporincididunt ut labore et dolore magna aliqua Quis suspendisse ultri ces gravida.') !!}</p>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- about-area-end -->

		<!-- faq-area -->
		@if(isset($content['faqs']) && count($content['faqs']) > 0)
		<section class="faq-area">
			<div class="faq-bg-shape" data-background="assets/img/images/faq_shape01.png"></div>
			<div class="faq-shape-wrap">
				<img src="assets/img/images/faq_shape02.png" alt="">
				<img src="assets/img/images/faq_shape03.png" alt="">
			</div>
			<div class="container">
				<div class="row align-items-end justify-content-center">
					<div class="col-lg-6 col-md-9">
						<div class="faq-img-wrap">
							<img src="assets/img/images/faq_img01.jpg" alt="">
							<img src="assets/img/images/faq_img02.jpg" alt="" data-parallax='{"y" : 100 }'>
						</div>
					</div>
					<div class="col-lg-6">
						<div class="faq-content">
							<div class="section-title mb-30 tg-heading-subheading animation-style2">
								<span class="sub-title tg-element-title">FAQ</span>
								<h2 class="title tg-element-title">Frequently Asked Questions</h2>
							</div>
							<div class="accordion" id="accordionFAQ">
                                @foreach($content['faqs'] as $index => $faq)
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading{{ $index }}">
                                        <button class="accordion-button {{ $index > 0 ? 'collapsed' : '' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $index }}" aria-expanded="{{ $index === 0 ? 'true' : 'false' }}" aria-controls="collapse{{ $index }}">
                                            {{ $faq['question'] }}
                                        </button>
                                    </h2>
                                    <div id="collapse{{ $index }}" class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}" aria-labelledby="heading{{ $index }}" data-bs-parent="#accordionFAQ">
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
			</div>
		</section>
		@endif
		<!-- faq-area-end -->

		<!-- request-area -->
		<section class="request-area request-bg" data-background="assets/img/bg/request_bg.jpg">
			<div class="container">
				<div class="row align-items-center">
					<div class="col-lg-5">
						<div class="request-content tg-heading-subheading animation-style2">
							<h2 class="title tg-element-title">{{ $request['title'] ?? 'Let\'s request a schedule For free consultation' }}</h2>
						</div>
					</div>
					<div class="col-lg-7">
						<div class="request-content-right">
							<div class="request-contact">
								<div class="icon">
									<i class="flaticon-mail"></i>
								</div>
								<div class="content" style="display: none;">
									<span>{{ $request['phone_label'] ?? 'Hotline 24/7' }}</span>
									<a href="tel:{{ preg_replace('/[^0-9+]/', '', $request['phone_number'] ?? '+123 8989 444') }}">{{ $request['phone_number'] ?? '+123 8989 444' }}</a>
								</div>
                                <div class="content">
                                    <a href="mailto:info@lei-register.co.uk">info@lei-register.co.uk</a>
                                </div>
							</div>
							<div class="request-btn">
                                <span></span>
								<a href="{{ $request['button_url'] ?? '/contact' }}" class="btn">{{ $request['button_text'] ?? 'Request a schedule' }}</a>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="request-shape">
				<img src="assets/img/images/request_shape.png" alt="">
			</div>
		</section>
		<!-- request-area-end -->

		<!-- Other sections remain unchanged -->
		{!! $content['main_content'] ?? '' !!}

</main>
<!-- main-area-end -->

@include('partials.footer')

@endsection