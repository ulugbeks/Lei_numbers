<!-- footer-area -->
<footer>
    <div class="footer-area footer-bg" data-background="{{ asset('assets/img/bg/footer_bg.jpg') }}">
        <div class="container">
            <div class="footer-top">
                <div class="row">
                    <div class="col-lg-3 col-md-7">
                        <div class="footer-widget">
                            <h4 class="fw-title">Location</h4>
                            <div class="footer-info">
                                <ul class="list-wrap">
                                    <h5 style="color: #fff;">Trusted LEI</h5>
                                    <li>
                                        <!-- <div class="icon">
                                            <i class="flaticon-pin"></i>
                                        </div> -->
                                        <div class="content">
                                            <div class="content">
                                            <p>Reg.no. 40103626380</p>
                                        </div>
                                            <p>Republikas laukums 3 - 12<br> Riga LV-1010, Latvia</p>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="icon">
                                            <i class="flaticon-mail"></i>
                                        </div>
                                        <div class="content">
                                            <a href="mailto:info@trustedlei.eu">info@trustedlei.eu</a>
                                        </div>
                                    </li>
                                    <li style="display: none;">
                                        <div class="icon">
                                            <i class="flaticon-clock"></i>
                                        </div>
                                        <div class="content">
                                            <p>Mon – Fri: 9.00 AM – 5.00 PM <br> Saturday: <span>CLOSED</span> <br>Sunday: <span>CLOSED</span></p>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-5 col-sm-6">
                        <div class="footer-widget">
                            <h4 class="fw-title">Menu</h4>
                            <div class="footer-link">
                                @php
                                // Render the main menu
                                $mainMenu = App\Models\Menu::where('name', 'main menu')->orWhere('location', 'header')->where('active', true)->first();
                                
                                if ($mainMenu && $mainMenu->rootItems()->where('active', true)->count() > 0) {
                                    $mainMenuItems = $mainMenu->rootItems()->where('active', true)->orderBy('order')->get();
                                    @endphp
                                    <ul class="list-wrap">
                                        @foreach($mainMenuItems as $item)
                                        <li>
                                            <a href="{{ $item->url }}" @if($item->target == '_blank') target="_blank" @endif>
                                                @if($item->icon)
                                                <i class="{{ $item->icon }}"></i>
                                                @endif
                                                {{ $item->title }}
                                            </a>
                                        </li>
                                        @endforeach
                                    </ul>
                                    @php
                                } else {
                                    @endphp
                                    <ul class="list-wrap">
                                        <li><a href="about">About Us</a></li>
                                        <li><a href="#">Register Lei</a></li>
                                        <li><a href="/about-lei/">About LEI</a></li>
                                        <li><a href="/blog/">Blog</a></li>
                                        <li><a href="/contact/">Contacts</a></li>
                                    </ul>
                                    @php
                                }
                                @endphp
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-5 col-sm-6">
                        <div class="footer-widget">
                            <h4 class="fw-title">Quick links</h4>
                            <div class="footer-link">
                                @php
                                // Render the footer menu
                                $footerMenu = App\Models\Menu::where('name', 'footer menu')->orWhere('location', 'footer')->where('active', true)->first();
                                
                                if ($footerMenu && $footerMenu->rootItems()->where('active', true)->count() > 0) {
                                    $footerMenuItems = $footerMenu->rootItems()->where('active', true)->orderBy('order')->get();
                                    @endphp
                                    <ul class="list-wrap">
                                        @foreach($footerMenuItems as $item)
                                        <li>
                                            <a href="{{ $item->url }}" @if($item->target == '_blank') target="_blank" @endif>
                                                @if($item->icon)
                                                <i class="{{ $item->icon }}"></i>
                                                @endif
                                                {{ $item->title }}
                                            </a>
                                        </li>
                                        @endforeach
                                    </ul>
                                    @php
                                } else {
                                    @endphp
                                    <ul class="list-wrap">
                                        <li><a href="#">How it's Work</a></li>
                                        <li><a href="#">Partners</a></li>
                                        <li><a href="#">Terms and Conditions</a></li>
                                        <li><a href="#">Privacy Policy</a></li>
                                        <li><a href="#">Cookies</a></li>
                                    </ul>
                                    @php
                                }
                                @endphp
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-7">
                        <div class="footer-widget">
                            <h4 class="fw-title">Subscribe to our newsletter</h4>
                            <div class="footer-newsletter">
                                <p>Sign up to get the latest updates.</p>
                                <form action="#">
                                    <input type="email" placeholder="Your e-mail">
                                    <button type="submit">Subscribe</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="left-sider">
                            <!-- <div class="f-logo">
                                <a href="/"><img src="{{ asset('assets/img/logo/logo-light.svg') }}" alt=""></a>
                            </div> -->
                            <div class="copyright-text">
                                <p><!--<a href="/"><img src="{{ asset('assets/img/logo/logo-light.svg') }}" alt=""></a>--> Copyright © 2025. Trusted LEI | All Rights Reserved.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="footer-social">
                            <ul class="list-wrap">
                                <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                                <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                                <li><a href="#"><i class="fab fa-instagram"></i></a></li>
                                <li><a href="#"><i class="fab fa-youtube"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- footer-area-end -->