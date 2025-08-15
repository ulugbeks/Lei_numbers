@extends('layouts.app')

@section('title', $page->meta_title ?? $page->title ?? 'Contact Us')

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
						<h2 class="title">{{ $page->title ?? 'Contact Us' }}</h2>
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
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
						{!! $content['main_content'] ?? '' !!}
					</div>
				</div>
				<div class="col-lg-7">
					<div class="contact-form">
						<form id="contact-form" action="{{ url('/contact-submit') }}" method="POST" class="register-form">
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
								<!-- Phone -->
								<div class="col-md-6">
									<div class="form-grp">
										<input type="tel" name="phone" id="phone" placeholder="Phone number *" class="form-control-custom" required>
									</div>
								</div>
								<!-- Email -->
								<div class="col-md-6">
									<div class="form-grp">
										<input type="email" name="email" placeholder="E-mail *" required>
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
								

								<div class="col-md-12">
									<div class="form-grp">
										<textarea id="message" name="message" rows="4" cols="50" placeholder="Message" class="form-control-custom"></textarea>
										
									</div>
								</div>
								<!-- Agreement Checkbox -->
								<div class="col-md-12">
									<div class="">
										<div class="terms-checkbox" style="align-items:center;">
											<input type="checkbox" id="terms" name="terms" required="">
											<label for="terms" style="margin-bottom: 0;">
												I agree to the <a href="{{ route('privacy-policy') }}" target="_blank">Privacy Policy</a> and <a href="{{ route('terms-and-conditions') }}" target="_blank">Terms and Conditions</a>. <span class="required">*</span>
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
		<div class="contact-shape">
			<img src="assets/img/images/contact_shape.png" alt="">
		</div>
	</section>
	<!-- contact-area-end -->

	<!-- contact-map -->
	<div class="contact-map">
		<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2175.641787175376!2d24.096631377343385!3d56.95493827355287!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x46eecfdb6fa6d64d%3A0x57faecb8a14f1b33!2sRepublikas%20Laukums%203%2C%20Centra%20rajons%2C%20R%C4%ABga%2C%20LV-1010!5e0!3m2!1sen!2slv!4v1754919020306!5m2!1sen!2slv" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
	</div>
	<!-- contact-map-end -->

</main>
<!-- main-area-end -->

@include('partials.footer')

@endsection
