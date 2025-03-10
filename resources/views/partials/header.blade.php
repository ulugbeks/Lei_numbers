<!-- preloader -->
<div id="preloader">
	<div id="loading-center">
		<div class="loader">
			<div class="loader-outter"></div>
			<div class="loader-inner"></div>
		</div>
	</div>
</div>
<!-- preloader-end -->

<!-- Scroll-top -->
<button class="scroll-top scroll-to-target" data-target="html">
	<i class="fas fa-angle-up"></i>
</button>
<!-- Scroll-top-end-->

<!-- header-area -->
<header class="transparent-header">
	<div class="heder-top-wrap">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-lg-7">
					<div class="header-top-left">
						<ul class="list-wrap">
							<li><i class="flaticon-location"></i>International House, 6 South Molton St. London EW1K 5QF, UK</li>
							<li><i class="flaticon-mail"></i><a href="mailto:gerow@gmail.com">info@registerlei.org</a></li>
						</ul>
					</div>
				</div>
				<div class="col-lg-5">
					<div class="header-top-right">
						<div class="header-contact">
							<a href="tel:0123456789"><i class="flaticon-phone-call"></i>+44 20 8040 0288</a>
						</div>
						<div class="header-social">
							<ul class="list-wrap">
								<li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
								<li><a href="#"><i class="fab fa-twitter"></i></a></li>
								<li><a href="#"><i class="fab fa-instagram"></i></a></li>
								<li><a href="#"><i class="fab fa-pinterest-p"></i></a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="sticky-header" class="menu-area" style="background-color: #fff">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="mobile-nav-toggler"><i class="fas fa-bars"></i></div>
					<div class="menu-wrap">
						<nav class="menu-nav">
							<div class="logo">
								<a href="/"><img src="{{ asset('assets/img/logo/logo-black.svg') }}" alt="Logo"></a>
							</div>
							<div class="navbar-wrap main-menu d-none d-lg-flex">
								<ul class="navigation">
									<li class="active"><a href="/">Home</a>
									</li>
									<li>
    									   <a class="nav-link" href="{{ url('/about-lei') }}">What is LEI</a>
									</li>
									<li><a href="/about/">About Us</a>
									</li>
									<li><a href="/news/">News</a>
									</li>
									<li><a href="/contact/">Contacts</a></li>
								</ul>
							</div>
							<div class="header-action d-none d-md-block">
								<ul class="list-wrap">
									<li class="header-search"><a href="#"><i class="flaticon-search"></i></a></li>
									<li class="header-btn"><a href="/registration-lei/" class="btn btn-two">Apply for LEI</a></li>
								</ul>
							</div>
						</nav>
					</div>

					<!-- Mobile Menu  -->
					<div class="mobile-menu">
						<nav class="menu-box">
							<div class="close-btn"><i class="fas fa-times"></i></div>
							<div class="nav-logo">
								<a href="index.html"><img src="assets/img/logo/logo.png" alt="Logo"></a>
							</div>
							<div class="mobile-search">
								<form action="#">
									<input type="text" placeholder="Search here...">
									<button><i class="flaticon-search"></i></button>
								</form>
							</div>
							<div class="menu-outer">
								<!--Here Menu Will Come Automatically Via Javascript / Same Menu as in Header-->
							</div>
							<div class="social-links">
								<ul class="clearfix list-wrap">
									<li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
									<li><a href="#"><i class="fab fa-twitter"></i></a></li>
									<li><a href="#"><i class="fab fa-instagram"></i></a></li>
									<li><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
									<li><a href="#"><i class="fab fa-youtube"></i></a></li>
								</ul>
							</div>
						</nav>
					</div>
					<div class="menu-backdrop"></div>
					<!-- End Mobile Menu -->

				</div>
			</div>
		</div>
	</div>

	<!-- header-search -->
	<div class="search-popup-wrap" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="search-close">
			<span><i class="fas fa-times"></i></span>
		</div>
		<div class="search-wrap text-center">
			<div class="container">
				<div class="row">
					<div class="col-12">
						<h2 class="title">... Search Here ...</h2>
						<div class="search-form">
							<form action="#">
								<input type="text" name="search" placeholder="Type keywords here">
								<button class="search-btn"><i class="fas fa-search"></i></button>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- header-search-end -->

</header>
        <!-- header-area-end -->