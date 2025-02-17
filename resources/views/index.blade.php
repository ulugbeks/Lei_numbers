@extends('layouts.app')

@section('title', 'Home')

@section('content')

@include('partials.header')

<!-- main-area -->
<main class="fix">

	<!-- banner-area -->
	<section class="banner-area-two banner-bg-two" data-background="assets/img/banner/h2_banner_bg.jpg">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-lg-6">
					<div class="banner-content-two">
						<span class="sub-title" data-aos="fade-up" data-aos-delay="0">We Are Expert In This Field</span>
						<h2 class="title" data-aos="fade-up" data-aos-delay="300">Get a Smart Way For Your Business</h2>
						<p data-aos="fade-up" data-aos-delay="500">Agilos helps you to convert your data into a strategic asset and get top-notch business insights.</p>
						<div class="banner-btn">
							<a href="services.html" class="btn" data-aos="fade-right" data-aos-delay="700">Our Services</a>
							<a href="https://www.youtube.com/watch?v=6mkoGSqTqFI" class="play-btn popup-video" data-aos="fade-left" data-aos-delay="700"><i class="fas fa-play"></i> <span>Watch The Video</span></a>
						</div>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="banner-img text-center">
						<img src="assets/img/banner/h2_banner_img.png" alt="" data-aos="fade-left" data-aos-delay="400">
					</div>
				</div>
			</div>
		</div>
		<div class="banner-shape-wrap">
			<img src="assets/img/banner/h2_banner_shape01.png" alt="">
			<img src="assets/img/banner/h2_banner_shape02.png" alt="">
			<img src="assets/img/banner/h2_banner_shape03.png" alt="" data-aos="zoom-in-up" data-aos-delay="800">
		</div>
	</section>
	<!-- banner-area-end -->

	<section class="pricing-area custom-pricing-area">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-xl-12">
					<div class="pricing-item-wrap">
						<div class="tabs-custom">
							<button class="tab-custom active" data-tab="register">REGISTER</button>
							<button class="tab-custom" data-tab="renew">RENEW</button>
						</div>
						<div id="register" class="content-custom active">
							<div class="step-section">
								<div class="step-header">
									<div class="step-number">1</div>
									<h3 class="step-title">Select a plan</h3>
								</div>
								<p class="step-description">Save money on each annual renewal based on multi-year plans.</p>

								<div class="row justify-content-center plan-cards">
									<div class="col-lg-4 col-md-6 col-sm-10">
										<div class="plan-card" data-plan="1-year">
											<h4 class="plan-title">1 year</h4>
											<div class="plan-price">$75 <span class="period">/ year</span></div>
											<div class="plan-total">Total $75</div>
										</div>
									</div>
									<div class="col-lg-4 col-md-6 col-sm-10">
										<div class="plan-card selected" data-plan="3-years">
											<span class="popular-tag">Most popular</span>
											<h4 class="plan-title">3 years</h4>
											<div class="plan-price">$55 <span class="period">/ year</span></div>
											<div class="plan-total">Total $165</div>
										</div>
									</div>
									<div class="col-lg-4 col-md-6 col-sm-10">
										<div class="plan-card" data-plan="5-years">
											<h4 class="plan-title">5 years</h4>
											<div class="plan-price">$50 <span class="period">/ year</span></div>
											<div class="plan-total">Total $250</div>
										</div>
									</div>
								</div>
							</div>

							<div class="step-section form-step">
								<div class="step-header">
									<div class="step-number">2</div>
									<h3 class="step-title">Complete the form</h3>
								</div>
								<p class="step-description">Start typing, and let us fill all the relevant details for you.</p>

								<form id="register-form" action="{{ url('/contact-submit') }}" method="POST">
									@csrf
									<div class="row">
										<div class="col-md-6">
											<div class="form-group-custom">
												<label class="form-label">Country <span class="required">*</span></label>
												<select name="country" id="country" class="form-control-custom select2" required>
													<option value="" disabled selected>Select Your Country...</option>
													@foreach (config('countries') as $code => $name)
													<option value="{{ $code }}" data-code="{{ strtolower($code) }}">{{ $name }}</option>
													@endforeach
												</select>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group-custom">
												<label class="form-label">Applicant’s full name <span class="required">*</span></label>
												<input type="text" name="full_name" class="form-control-custom" required>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-md-6">
											<div class="form-group-custom">
												<label class="form-label">Legal entity name <span class="required">*</span></label>
												<input type="text" name="company_name" class="form-control-custom">
											</div>
										</div>

										<div class="col-md-6">
											<div class="form-group-custom">
												<label class="form-label">Registration ID * <span class="required">*</span></label>
												<input type="text" name="registration_id" class="form-control-custom">
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-md-6">
											<div class="form-group-custom">
												<label class="form-label">Email <span class="required">*</span></label>
												<input type="email" name="email" class="form-control-custom" required>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group-custom">
												<label class="form-label">Phone Number <span class="required">*</span></label>
												<input type="tel" name="phone" id="phone" class="form-control-custom" required>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-md-6">
											<div class="form-group-custom">
												<p class="upload-instruction">To verify announcement, please upload a document listing the legal entity's authorized representatives (e.g., board meeting minutes, articles of association):</p>
												<div class="upload-area">
													<div class="upload-icon"><i class="fa fa-upload"></i></div>
													<div class="upload-text">Browse files or drag and drop</div>
												</div>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-md-4">
											<div class="form-group-custom">
												<label class="form-label">Office, building, street <span class="required">*</span></label>
												<input type="text" name="address" class="form-control-custom" required>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group-custom">
												<label class="form-label">City, state <span class="required">*</span></label>
												<input type="text" name="city" class="form-control-custom" required>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group-custom">
												<label class="form-label">ZIP code <span class="required">*</span></label>
												<input type="text" name="zip_code" class="form-control-custom" required>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-md-12">
											<div class="switch-container">
												<label>Headquarters address is identical to legal address?</label>
												<label class="switch">
													<input type="checkbox" name="same_address">
													<span class="slider"></span>
												</label>
											</div>
										</div>
										<div class="col-md-12">
											<div class="switch-container">
												<label>Is the legal entity solely controlled by private individuals (natural persons)?</label>
												<label class="switch">
													<input type="checkbox" name="private_controlled">
													<span class="slider"></span>
												</label>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-md-12">
											<div class="terms-checkbox">
												<input type="checkbox" id="terms" name="terms" required>
												<label for="terms">
													I accept LEI Register's <ahref="#">Terms & Conditions</a> and <ahref="#">Privacy Policy</a> <span class="required">*</span>
													</label>
												</div>
											</div>
										</div>

										<button type="submit" class="submit-btn">CONFIRM & CONTINUE</button>
									</form>
								</div>
							</div>

							<div id="renew" class="content-custom">
								<div class="step-section form-step">
									<form id="renew-form" action="{{ url('/renew-submit') }}" method="POST">
										@csrf
										<div class="row">
											<div class="col-md-12">
												<div class="form-group-custom">
													<label class="form-label">Insert LEI or company name <span class="required">*</span></label>
													<input type="text" name="lei" class="form-control-custom" required>
												</div>
											</div>
										</div>
										<button type="submit" class="submit-btn">CONFIRM & CONTINUE</button>
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
		<section class="features-area">
			<div class="container">
				<div class="row justify-content-center">
					<div class="col-lg-4 col-md-6">
						<div class="features-item">
							<div class="features-content">
								<div class="content-top">
									<div class="icon">
										<i class="flaticon-puzzle-piece"></i>
									</div>
									<h2 class="title">Quality Services</h2>
								</div>
								<p>eiusmod temporincididunt ut labore magna aliqua Quisery.</p>
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
									<h2 class="title">Innovation Ideas</h2>
								</div>
								<p>eiusmod temporincididunt ut labore magna aliqua Quisery.</p>
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
									<h2 class="title">Business Growth</h2>
								</div>
								<p>eiusmod temporincididunt ut labore magna aliqua Quisery.</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- features-area-end -->

		<!-- about-area -->
		<section class="about-area-two pt-110 pb-120">
			<div class="container">
				<div class="row align-items-center justify-content-center">
					<div class="col-lg-7 col-md-9 order-0 order-lg-2">
						<div class="about-img-two">
							<div class="main-img">
								<img src="assets/img/images/about_img02.jpg" alt="">
								<a href="https://www.youtube.com/watch?v=6mkoGSqTqFI" class="play-btn popup-video"><i class="fas fa-play"></i></a>
							</div>
							<img src="assets/img/images/about_img03.jpg" alt="">
						</div>
					</div>
					<div class="col-lg-5">
						<div class="about-content-two">
							<div class="section-title mb-30 tg-heading-subheading animation-style2">
								<span class="sub-title tg-element-title">Who We are</span>
								<h2 class="title tg-element-title">Building Your Own Startup Has Been Simpler</h2>
							</div>
							<p>Morem ipsum dolor sit amet, consectetur adipiscing elita florai psum dolor sit amet, consecteture.Borem ipsum dolor sit amet, consectetur adipiscing elita florai psum.</p>
							<div class="about-list">
								<ul class="list-wrap">
									<li><img src="assets/img/icons/check_icon.svg" alt="">100% Better results</li>
									<li><img src="assets/img/icons/check_icon.svg" alt="">Valuable Ideas</li>
									<li><img src="assets/img/icons/check_icon.svg" alt="">Budget Friendly Theme</li>
									<li><img src="assets/img/icons/check_icon.svg" alt="">Happy Customers</li>
								</ul>
							</div>
							<div class="success-wrap">
								<ul class="list-wrap">
									<li>
										<h2 class="count">+150,000</h2>
										<p>Total revenue in 1 year</p>
									</li>
									<li>
										<h2 class="count">90%</h2>
										<p>Increase in sales</p>
									</li>
								</ul>
							</div>
							<a href="about.html" class="btn transparent-btn">Get Started With Us</a>
						</div>
					</div>
				</div>
			</div>
			<div class="about-shape-wrap">
				<img src="assets/img/images/about_shape01.png" alt="">
				<img src="assets/img/images/about_shape02.png" alt="">
			</div>
		</section>
		<!-- about-area-end -->

		<!-- services-area -->
		<section class="services-area services-bg" data-background="assets/img/bg/services_bg.jpg">
			<div class="container">
				<div class="row justify-content-center">
					<div class="col-xl-6 col-lg-8">
						<div class="section-title white-title text-center mb-50 tg-heading-subheading animation-style2">
							<span class="sub-title tg-element-title">Our Dedicated Services</span>
							<h2 class="title tg-element-title">Spotlight Some Most <br> Important Features We Have</h2>
							<p>Borem ipsum dolor sit amet consectetur adipiscing elita</p>
						</div>
					</div>
				</div>
				<div class="row services-active">
					<div class="col-lg-4">
						<div class="services-item">
							<div class="services-content">
								<div class="content-top">
									<div class="icon">
										<i class="flaticon-briefcase"></i>
									</div>
									<h2 class="title">Business Analysis</h2>
								</div>
								<div class="services-thumb">
									<img src="assets/img/services/services_img01.jpg" alt="">
									<a href="services-details.html" class="btn transparent-btn">Our Services</a>
								</div>
								<ul class="list-wrap">
									<li>seusmeyd tempose atidim area</li>
									<li>aliquam duhipsum is simply free</li>
									<li>Get Life Time Access</li>
								</ul>
							</div>
						</div>
					</div>
					<div class="col-lg-4">
						<div class="services-item">
							<div class="services-content">
								<div class="content-top">
									<div class="icon">
										<i class="flaticon-taxes"></i>
									</div>
									<h2 class="title">Tax Strategy</h2>
								</div>
								<div class="services-thumb">
									<img src="assets/img/services/services_img02.jpg" alt="">
									<a href="services-details.html" class="btn transparent-btn">Our Services</a>
								</div>
								<ul class="list-wrap">
									<li>seusmeyd tempose atidim area</li>
									<li>aliquam duhipsum is simply free</li>
									<li>Get Life Time Access</li>
								</ul>
							</div>
						</div>
					</div>
					<div class="col-lg-4">
						<div class="services-item">
							<div class="services-content">
								<div class="content-top">
									<div class="icon">
										<i class="flaticon-money"></i>
									</div>
									<h2 class="title">Financial Advice</h2>
								</div>
								<div class="services-thumb">
									<img src="assets/img/services/services_img03.jpg" alt="">
									<a href="services-details.html" class="btn transparent-btn">Our Services</a>
								</div>
								<ul class="list-wrap">
									<li>seusmeyd tempose atidim area</li>
									<li>aliquam duhipsum is simply free</li>
									<li>Get Life Time Access</li>
								</ul>
							</div>
						</div>
					</div>
					<div class="col-lg-4">
						<div class="services-item">
							<div class="services-content">
								<div class="content-top">
									<div class="icon">
										<i class="flaticon-taxes"></i>
									</div>
									<h2 class="title">Tax Strategy</h2>
								</div>
								<div class="services-thumb">
									<img src="assets/img/services/services_img02.jpg" alt="">
									<a href="services-details.html" class="btn transparent-btn">Our Services</a>
								</div>
								<ul class="list-wrap">
									<li>seusmeyd tempose atidim area</li>
									<li>aliquam duhipsum is simply free</li>
									<li>Get Life Time Access</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<!-- services-area-end -->

		<!-- counter-area -->
		<section class="counter-area counter-bg" data-background="assets/img/bg/counter_bg.jpg">
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
		</section>
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
					<h2 class="title tg-element-title">Let’s Request A Schedule For <br> Free Consultation</h2>
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
						<a href="contact.html" class="btn">Request a Schedule</a>
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

<!-- testimonial-area -->
<section class="testimonial-area testimonial-bg" data-background="assets/img/bg/testimonial_bg.jpg">
	<div class="container">
		<div class="row align-items-center justify-content-center">
			<div class="col-lg-5 col-md-8">
				<div class="testimonial-img">
					<img src="assets/img/images/testimonial_img.jpg" alt="">
					<div class="review-wrap">
						<img src="assets/img/icons/rating.svg" alt="">
						<div class="content">
							<h2 class="title">15k</h2>
							<p>Positive <br> Review</p>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-7">
				<div class="testimonial-item-wrap">
					<div class="testimonial-active">
						<div class="testimonial-item">
							<div class="testimonial-content">
								<div class="content-top">
									<div class="rating">
										<i class="fas fa-star"></i>
										<i class="fas fa-star"></i>
										<i class="fas fa-star"></i>
										<i class="fas fa-star"></i>
										<i class="fas fa-star"></i>
									</div>
									<div class="testimonial-quote">
										<img src="assets/img/icons/quote.svg" alt="">
									</div>
								</div>
								<p>“ Morem ipsum dolor sit amet, consectetur adipiscing elita florai sum dolor sit amet, consecteture.Borem ipsum dolor sit amet, consectetur adipiscing elita Moremsit amet.</p>
								<div class="testimonial-info">
									<h4 class="title">Mr.Robey Alexa</h4>
									<span>CEO, Gerow Agency</span>
								</div>
							</div>
						</div>
						<div class="testimonial-item">
							<div class="testimonial-content">
								<div class="content-top">
									<div class="rating">
										<i class="fas fa-star"></i>
										<i class="fas fa-star"></i>
										<i class="fas fa-star"></i>
										<i class="fas fa-star"></i>
										<i class="fas fa-star"></i>
									</div>
									<div class="testimonial-quote">
										<img src="assets/img/icons/quote.svg" alt="">
									</div>
								</div>
								<p>“ Morem ipsum dolor sit amet, consectetur adipiscing elita florai sum dolor sit amet, consecteture.Borem ipsum dolor sit amet, elita Moremsit amet.</p>
								<div class="testimonial-info">
									<h4 class="title">Guy Hawkins</h4>
									<span>CEO, Gerow Agency</span>
								</div>
							</div>
						</div>
					</div>
					<div class="testimonial-nav"></div>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- testimonial-area-end -->

<!-- pricing-area -->
<section class="pricing-area">
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-xl-6 col-lg-8">
				<div class="section-title text-center mb-60 tg-heading-subheading animation-style2">
					<span class="sub-title tg-element-title">Pricing Chart</span>
					<h2 class="title tg-element-title">Best Pricing Plane For You</h2>
				</div>
			</div>
		</div>
		<div class="pricing-item-wrap">
			<div class="pricing-tab">
				<span class="tab-btn monthly_tab_title">Monthly</span>
				<span class="pricing-tab-switcher"></span>
				<span class="tab-btn annual_tab_title">Yearly</span>
			</div>
			<div class="row justify-content-center">
				<div class="col-lg-4 col-md-6 col-sm-9">
					<div class="pricing-box">
						<div class="pricing-head">
							<h2 class="title">1 Year</h2>
							<p>Ever find yourself staring at your follow computer screen a good</p>
						</div>
						<div class="pricing-price">
							<h2 class="price monthly_price"><strong>$</strong>19.00<span>/month</span></h2>
							<h2 class="price annual_price"><strong>$</strong>119.00<span>/month</span></h2>
						</div>
					</div>
				</div>
				<div class="col-lg-4 col-md-6 col-sm-9">
					<div class="pricing-box active">
						<span class="popular-tag">3 Years</span>
						<div class="pricing-head">
							<h2 class="title">Standard Plan</h2>
							<p>Ever find yourself staring at your follow computer screen a good</p>
						</div>
						<div class="pricing-price">
							<h2 class="price monthly_price"><strong>$</strong>39.00<span>/month</span></h2>
							<h2 class="price annual_price"><strong>$</strong>329.00<span>/month</span></h2>
						</div>
					</div>
				</div>
				<div class="col-lg-4 col-md-6 col-sm-9">
					<div class="pricing-box">
						<div class="pricing-head">
							<h2 class="title">5 Years</h2>
							<p>Ever find yourself staring at your follow computer screen a good</p>
						</div>
						<div class="pricing-price">
							<h2 class="price monthly_price"><strong>$</strong>99.00<span>/month</span></h2>
							<h2 class="price annual_price"><strong>$</strong>899.00<span>/month</span></h2>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- pricing-area-end -->

<!-- contact-area -->
<section class="contact-area contact-bg" data-background="assets/img/bg/contact_bg.jpg">
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
					<form action="{{ url('/contact-submit') }}" method="POST" class="register-form">
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
									<select name="country" id="country" class="form-control select2" required>
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
									<input type="hidden" name="phone_code" id="phone_code">
									<input type="tel" name="phone" id="phone" class="form-control" placeholder="Your Phone *" required>
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
<div class="brand-aera pb-100">
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
</div>
<!-- brand-area-end -->

</main>
<!-- main-area-end -->

@include('partials.footer')

@endsection
