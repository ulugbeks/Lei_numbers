@extends('layouts.app')

@section('title', 'Home')

@section('content')

@include('partials.header')

<!-- main-area -->
<main class="fix">

	<!-- breadcrumb-area -->
	<section class="breadcrumb-area breadcrumb-bg" data-background="assets/img/bg/breadcrumb_bg.jpg">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="breadcrumb-content">
						<h2 class="title">Contact Us</h2>
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="index.html">Home</a></li>
								<li class="breadcrumb-item active" aria-current="page">Contact</li>
							</ol>
						</nav>
					</div>
				</div>
			</div>
		</div>
		<div class="breadcrumb-shape-wrap">
			<img src="assets/img/images/breadcrumb_shape01.png" alt="">
			<img src="assets/img/images/breadcrumb_shape02.png" alt="">
		</div>
	</section>
	<!-- breadcrumb-area-end -->

	<!-- contact-area -->
<section class="contact-area contact-bg" data-background="assets/img/bg/contact_bg.jpg">
	<div class="container">
		<div class="row align-items-center">
			<div class="col-lg-5">
					<div class="inner-contact-info">
						<h2 class="title">Our Office Address</h2>
						<div class="contact-info-item">
							<h5 class="title-two">UK Office</h5>
							<ul class="list-wrap">
								<li>International House <br>6 South Molton St. London EW1K 5QF,<br> United Kingdom</li>
								<li>+44 20 8040 0288</li>
								<li>info@registerlei.org</li>
							</ul>
						</div>
						<!-- <div class="contact-info-item">
							<h5 class="title-two">Australia Office</h5>
							<ul class="list-wrap">
								<li>100 Wilshire Blvd, Suite 700 Santa <br> Monica, CA 90401, USA</li>
								<li>+44 20 8040 0288</li>
								<li>info@registerlei.org</li>
							</ul>
						</div> -->
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

	<!-- contact-map -->
	<div class="contact-map">
		<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3152.332792000835!2d144.96011341744386!3d-37.805673299999995!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6ad65d4c2b349649%3A0xb6899234e561db11!2sEnvato!5e0!3m2!1sen!2sbd!4v1685027435635!5m2!1sen!2sbd" allowfullscreen loading="lazy"></iframe>
	</div>
	<!-- contact-map-end -->


</main>
<!-- main-area-end -->

@include('partials.footer')

@endsection