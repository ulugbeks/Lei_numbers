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
	@endphp

	<!-- banner-area -->
	<section class="banner-area-two banner-bg-two" data-background="assets/img/banner/home-bg-.jpg">
	    <div class="container">
	        <div class="row align-items-center">
	            <div class="col-lg-8">
	                <div class="banner-content-two">
	                    <h1 class="title" data-aos="fade-up" data-aos-delay="300" style="color: #fff">{{ $banner['title'] ?? 'Apply for an LEI number' }}</h1>
	                    <p data-aos="fade-up" data-aos-delay="500" style="color: #fff">{{ $banner['description'] ?? '' }}</p>
	                    <div class="banner-btn">
	                        <a href="{{ $banner['button_url'] ?? '/about-lei' }}" class="btn" data-aos="fade-right" data-aos-delay="700">{{ $banner['button_text'] ?? 'What is LEI' }}</a>
	                    </div>
	                </div>
	            </div>
	            <div class="col-lg-4">
	                <!-- div class="banner-img text-center">
	                    <img src="assets/img/banner/h2_banner_img.png" alt="" data-aos="fade-left" data-aos-delay="400">
	                </div> -->
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
                            
                            <div class="step-navigation">
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

		<!-- about-area -->
		<section class="about-area about-bg" data-background="assets/img/bg/about_bg.jpg">
			<div class="container">
				<div class="row align-items-center">
					<div class="col-lg-5">
						<div class="about-img-wrap">
							<img src="assets/img/images/about_img01.png" alt="" class="main-img">
							<img src="assets/img/images/about_img_shape01.png" alt="">
							<img src="assets/img/images/about_img_shape02.png" alt="">
						</div>
					</div>
					<div class="col-lg-7">
						<div class="about-content">
							<div class="section-title mb-25 tg-heading-subheading animation-style2">
								<span class="sub-title tg-element-title">What We are Doing</span>
								<h2 class="title tg-element-title">Changing The Way To Do Best Business Solutions</h2>
							</div>
							<p>Borem ipsum dolor sit amet, consectetur adipiscing elita floraipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod temporincididunt ut labore et dolore magna aliqua Quis suspendisse ultri ces gravida.</p>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- about-area-end -->

		<!-- features-area -->
		<section class="features-area section-py-120">
			<div class="container">
				<div class="row justify-content-center">
					<div class="col-lg-4 col-md-6">
						<div class="features-item">
							<div class="features-content">
								<div class="content-top">
									<div class="icon">
										<i class="flaticon-puzzle-piece"></i>
									</div>
									<h2 class="title">Regsiter LEI</h2>
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
				</div>
			</div>
		</section>
		<!-- features-area-end -->

		<!-- counter-area -->
		<!-- <section class="counter-area counter-bg" data-background="assets/img/bg/counter_bg.jpg">
			<div class="container">
				<div class="row justify-content-center">
					<div class="col-lg-3 col-md-4 col-sm-6">
						<div class="counter-item">
							<h2 class="count"><span class="odometer" data-count="95"></span>%</h2>
							<p>Success Rate</p>
						</div>
					</div>
					<div class="col-lg-3 col-md-4 col-sm-6">
						<div class="counter-item">
							<h2 class="count"><span class="odometer" data-count="55"></span>K</h2>
							<p>Complete Projects</p>
						</div>
					</div>
					<div class="col-lg-3 col-md-4 col-sm-6">
						<div class="counter-item">
							<h2 class="count"><span class="odometer" data-count="25"></span>K</h2>
							<p>Satisfied Clients</p>
						</div>
					</div>
					<div class="col-lg-3 col-md-4 col-sm-6">
						<div class="counter-item">
							<h2 class="count"><span class="odometer" data-count="12"></span>K</h2>
							<p>Trade In The World</p>
						</div>
					</div>
				</div>
			</div>
			<div class="counter-shape-wrap">
				<img src="assets/img/images/counter_shape01.png" alt="" class="animationFramesOne">
				<img src="assets/img/images/counter_shape02.png" alt="" class="animationFramesOne">
			</div>
		</section> -->
		<!-- counter-area-end -->

		<!-- faq-area -->
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
								<span class="sub-title tg-element-title">Our Service Benifits</span>
								<h2 class="title tg-element-title">Keep Your Business Safe & Ensure High Availability.</h2>
							</div>
							<p>Ever find yourself staring at your computer s good consulting slogan to come to mind? Oftentimes.</p>
							<div class="accordion-wrap">
								<div class="accordion" id="accordionExample">
									<div class="accordion-item">
										<h2 class="accordion-header">
											<button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
												Interdum et malesuada fames ac ante ipsum
											</button>
										</h2>
										<div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
											<div class="accordion-body">
												<p>Ever find yourself staring at your computer screen a good consulting slogan to coind yourself sta your computer screen a good consulting slogan.</p>
											</div>
										</div>
									</div>
									<div class="accordion-item">
										<h2 class="accordion-header">
											<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
											data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
											Interdum et malesuada fames ac ante ipsum
											</button>
										</h2>
									<div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
										<div class="accordion-body">
											<p>Ever find yourself staring at your computer screen a good consulting slogan to coind yourself sta your computer screen a good consulting slogan.</p>
										</div>
									</div>
								</div>
								<div class="accordion-item">
									<h2 class="accordion-header">
										<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
										data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
										Interdum et malesuada fames ac ante ipsum
									</button>
								</h2>
								<div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
									<div class="accordion-body">
										<p>Ever find yourself staring at your computer screen a good consulting slogan to coind yourself sta your computer screen a good consulting slogan.</p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	</section>
<!-- faq-area-end -->

<!-- request-area -->
<section class="request-area request-bg" data-background="assets/img/bg/request_bg.jpg">
	<div class="container">
		<div class="row align-items-center">
			<div class="col-lg-5">
				<div class="request-content tg-heading-subheading animation-style2">
					<h2 class="title tg-element-title">Let’s request a schedule For <br> free consultation</h2>
				</div>
			</div>
			<div class="col-lg-7">
				<div class="request-content-right">
					<div class="request-contact">
						<div class="icon">
							<i class="flaticon-phone-call"></i>
						</div>
						<div class="content">
							<span>Hotline 24/7</span>
							<a href="tel:0123456789">+123 8989 444</a>
						</div>
					</div>
					<div class="request-btn">
						<a href="contact.html" class="btn">Request a schedule</a>
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

<!-- contact-area -->
<section class="contact-area contact-bg" data-background="assets/img/bg/contact_bg.jpg" style="display: none;">
	<div class="container">
		<div class="row align-items-center">
			<div class="col-lg-5">
				<div class="contact-content">
					<div class="section-title mb-30 tg-heading-subheading animation-style2">
						<span class="sub-title tg-element-title">GET IN TOUCH</span>
						<h2 class="title tg-element-title">We Are Connected To Help Your Business!</h2>
					</div>
					<p>Ever find yourself staring at your computer screen a good consulting slogan to come to mind? Oftentimes.</p>
				</div>
			</div>
			<div class="col-lg-7">
				<div class="contact-form">
					<form id="register-form" action="{{ url('/contact-submit') }}" method="POST" class="register-form">
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
									<select name="country" id="country" class="form-control-custom select2" required>
										<option value="" disabled selected>Select Your Country...</option>
										@foreach (config('countries') as $code => $name)
										<option value="{{ $code }}" data-code="{{ strtolower($code) }}">{{ $name }}</option>
										@endforeach
									</select>
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
									<input type="tel" name="phone" id="phone" placeholder="Phone number *" class="form-control-custom" required>
								</div>
							</div>
							<!-- Agreement Checkbox -->
							<div class="col-md-12">
								<div class="form-grp">
									<input type="checkbox" id="terms" name="terms" required>
									<label for="terms">
										I have read and accept the <a href="#">Terms and Conditions</a> and <a href="#">Privacy Policy</a>
									</label>
								</div>
							</div>
						</div>
						<button type="submit">Submit Now</button>
					</form>

				</div>
			</div>
		</div>
	</div>
	<div class="contact-shape">
		<img src="assets/img/images/contact_shape.png" alt="">
	</div>
</section>
<!-- contact-area-end -->

<!-- brand-area -->
<!-- <div class="brand-aera pb-100">
	<div class="container">
		<div class="row brand-active">
			<div class="col-lg-12">
				<div class="brand-item">
					<img src="assets/img/brand/brand_img01.png" alt="">
				</div>
			</div>
			<div class="col-lg-12">
				<div class="brand-item">
					<img src="assets/img/brand/brand_img02.png" alt="">
				</div>
			</div>
			<div class="col-lg-12">
				<div class="brand-item">
					<img src="assets/img/brand/brand_img03.png" alt="">
				</div>
			</div>
			<div class="col-lg-12">
				<div class="brand-item">
					<img src="assets/img/brand/brand_img04.png" alt="">
				</div>
			</div>
			<div class="col-lg-12">
				<div class="brand-item">
					<img src="assets/img/brand/brand_img05.png" alt="">
				</div>
			</div>
			<div class="col-lg-12">
				<div class="brand-item">
					<img src="assets/img/brand/brand_img03.png" alt="">
				</div>
			</div>
		</div>
	</div>
</div> -->
<!-- brand-area-end -->

</main>
<!-- main-area-end -->

@include('partials.footer')

@endsection
