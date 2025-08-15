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

<!-- Custom Dropdown CSS -->
<style>
/* Custom Dropdown Styles for User Profile */
.header-profile.dropdown {
    position: relative;
}

.header-profile .dropdown-toggle {
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 5px;
    text-decoration: none;
    color: inherit;
}

.header-profile .dropdown-toggle::after {
    content: '';
    display: inline-block;
    margin-left: 0.255em;
    vertical-align: 0.255em;
    border-top: 0.3em solid;
    border-right: 0.3em solid transparent;
    border-bottom: 0;
    border-left: 0.3em solid transparent;
}

.header-profile .dropdown-menu {
    position: absolute;
    top: 100%;
    right: 0;
    z-index: 1000;
    display: none;
    min-width: 10rem;
    padding: 0.5rem 0;
    margin: 0.125rem 0 0;
    font-size: 1rem;
    color: #212529;
    text-align: left;
    list-style: none;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid rgba(0, 0, 0, 0.15);
    border-radius: 0.25rem;
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.175);
}

.header-profile .dropdown-menu.show {
    display: block;
}

.header-profile .dropdown-item {
    display: block;
    width: 100%;
    padding: 0.25rem 1.5rem;
    clear: both;
    font-weight: 400;
    color: #212529;
    text-align: inherit;
    text-decoration: none;
    white-space: nowrap;
    background-color: transparent;
    border: 0;
    cursor: pointer;
    transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out;
}

.header-profile .dropdown-item:hover,
.header-profile .dropdown-item:focus {
    color: #1e2125;
    background-color: #f8f9fa;
}

.header-profile .dropdown-divider {
    height: 0;
    margin: 0.5rem 0;
    overflow: hidden;
    border-top: 1px solid #e9ecef;
}

/* Ensure dropdown stays on top */
.header-action {
    position: relative;
    z-index: 999;
}

/* Mobile responsive adjustments */
@media (max-width: 768px) {
    .header-profile .dropdown-menu {
        right: auto;
        left: 0;
    }
}
</style>

<!-- header-area -->
<header class="transparent-header">
	<div class="heder-top-wrap">
		<div class="container">
			<div class="row align-items-center">
				<div class="col-lg-7">
					<div class="header-top-left">
						<ul class="list-wrap">
							<li>Trusted LEI - trusted by companies worldwide. Powered by expertise. Built for compliance.</li>
							<!-- <li><i class="flaticon-mail"></i><a href="mailto:gerow@gmail.com">info@lei-register.co.uk</a></li> -->
						</ul>
					</div>
				</div>
				<div class="col-lg-5">
					<div class="header-top-right">
						<div class="header-contact">
							<a href="mailto:info@trustedlei.eu"><i class="flaticon-mail"></i> info@trustedlei.eu</a>
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
								@php
								// Render the main menu using the MenuHelper
								$mainMenu = App\Models\Menu::where('name', 'main menu')->orWhere('location', 'header')->where('active', true)->first();
								
								if ($mainMenu && $mainMenu->rootItems()->where('active', true)->count() > 0) {
									$menuItems = $mainMenu->rootItems()->where('active', true)->orderBy('order')->with(['children' => function($query) {
										$query->where('active', true)->orderBy('order');
									}])->get();
									@endphp
									<ul class="navigation">
										@foreach($menuItems as $item)
										<li class="{{ request()->is(ltrim($item->url, '/')) ? 'active' : '' }}">
											<a href="{{ $item->url }}" @if($item->target == '_blank') target="_blank" @endif>
												@if($item->icon)
												<i class="{{ $item->icon }}"></i>
												@endif
												{{ $item->title }}
											</a>
											
											@if($item->hasChildren())
											<ul class="submenu">
												@foreach($item->children as $child)
												<li class="{{ request()->is(ltrim($child->url, '/')) ? 'active' : '' }}">
													<a href="{{ $child->url }}" @if($child->target == '_blank') target="_blank" @endif>
														@if($child->icon)
														<i class="{{ $child->icon }}"></i>
														@endif
														{{ $child->title }}
													</a>
												</li>
												@endforeach
											</ul>
											@endif
										</li>
										@endforeach
									</ul>
									@php
								}
								@endphp
							</div>
							<div class="header-action d-none d-md-block">
								<ul class="list-wrap">
							        <li class="header-search"><a href="#"><i class="flaticon-search"></i></a></li>
							        
							        @guest
							            <li class="header-login">
							                <a href="{{ route('login') }}" class="">
							                    <i class="fas fa-user"></i>
							                </a>
							            </li>
							            <li class="header-btn">
							                <a href="{{ route('registration-lei') }}" class="btn btn-two">Apply for LEI</a>
							            </li>
							        @else
							            <li class="header-profile dropdown">
							                <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown">
							                    <i class="fas fa-user-circle"></i> {{ Auth::user()->name }}
							                </a>
							                <ul class="dropdown-menu">
							                    <li><a class="dropdown-item" href="{{ route('user.profile') }}">My Profile</a></li>
							                    <li><hr class="dropdown-divider"></li>
							                    <li>
							                        <form action="{{ route('logout') }}" method="POST">
							                            @csrf
							                            <button type="submit" class="dropdown-item">Logout</button>
							                        </form>
							                    </li>
							                </ul>
							            </li>
							            <li class="header-btn">
							                <a href="{{ route('registration-lei') }}" class="btn btn-two">Apply for LEI</a>
							            </li>
							        @endguest
							    </ul>
							</div>
						</nav>
					</div>

					<!-- Mobile Menu  -->
					<div class="mobile-menu">
						<nav class="menu-box">
							<div class="close-btn"><i class="fas fa-times"></i></div>
							<div class="nav-logo">
								<a href="index.html"><img src="{{ asset('assets/img/logo/logo-black.svg') }}"></a>
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

<!-- Custom Dropdown JavaScript -->
<script>
// Custom Dropdown JavaScript
document.addEventListener('DOMContentLoaded', function() {
    // Get all dropdown toggles
    const dropdownToggles = document.querySelectorAll('.dropdown-toggle');
    
    dropdownToggles.forEach(toggle => {
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            // Find the parent dropdown element
            const dropdown = this.closest('.dropdown');
            const menu = dropdown.querySelector('.dropdown-menu');
            
            // Check if this dropdown is currently open
            const isOpen = menu.classList.contains('show');
            
            // Close all dropdowns first
            document.querySelectorAll('.dropdown-menu.show').forEach(openMenu => {
                openMenu.classList.remove('show');
            });
            
            // If it wasn't open, open it. If it was open, it's now closed from above
            if (!isOpen) {
                menu.classList.add('show');
            }
        });
    });
    
    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
        // Check if click is outside any dropdown
        if (!e.target.closest('.dropdown')) {
            document.querySelectorAll('.dropdown-menu.show').forEach(menu => {
                menu.classList.remove('show');
            });
        }
    });
    
    // Close dropdown when pressing Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            document.querySelectorAll('.dropdown-menu.show').forEach(menu => {
                menu.classList.remove('show');
            });
        }
    });
    
    // Handle dropdown item clicks (especially for forms)
    document.querySelectorAll('.dropdown-item').forEach(item => {
        item.addEventListener('click', function(e) {
            // If it's not a form submit button, close the dropdown
            if (!this.type || this.type !== 'submit') {
                const menu = this.closest('.dropdown-menu');
                if (menu) {
                    menu.classList.remove('show');
                }
            }
        });
    });
});
</script>