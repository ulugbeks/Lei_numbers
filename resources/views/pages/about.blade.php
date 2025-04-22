@extends('layouts.app')

@section('title', 'About Us')

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
                        <h2 class="title">{{ $page->title ?? 'About Us' }}</h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">About Us</li>
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

    <!-- about-area -->
    <section class="section-py-120">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-lg-12">
                    <div class="about-content-eleven">
                        @php
                            $page = App\Models\Page::where('slug', 'about')->first();
                            $content = json_decode($page->content, true) ?: [];
                        @endphp
                        
                        {!! $content['main_content'] ?? '
                        <p>At Bedford Capital, we are dedicated to simplifying the Legal Entity Identifier (LEI) registration and renewal process for businesses, financial institutions, and organizations worldwide. We understand the importance of regulatory compliance in today\'s financial landscape, and our goal is to provide a seamless, efficient, and transparent solution for obtaining and managing your LEI.</p>
                        
                        <h2>Who We Are</h2>
                        <p>Bedford Capital is a trusted provider of LEI registration services, helping businesses meet international financial regulations. With a team of experienced professionals and a deep understanding of global compliance requirements, we ensure that our clients receive fast, reliable, and cost-effective LEI solutions.</p>
                        
                        <h2>Our Mission</h2>
                        <p>Our mission is to empower businesses by making LEI registration and management simple, secure, and accessible. We believe in removing bureaucratic barriers and providing a streamlined process that saves time and effort.</p>
                        
                        <h2>What We Offer</h2>
                        <div class="about-list-two">
                            <ul class="list-wrap">
                                <li><img src="assets/img/icons/check_icon.svg" alt=""> New LEI Registration – Quick and hassle-free application process for first-time LEI registrations.</li>
                                <li><img src="assets/img/icons/check_icon.svg" alt=""> LEI Renewal & Transfer – Easy renewal and transfer of existing LEIs to ensure continuous compliance.</li>
                                <li><img src="assets/img/icons/check_icon.svg" alt=""> Competitive Pricing – Affordable rates with no hidden fees or unexpected charges.</li>
                                <li><img src="assets/img/icons/check_icon.svg" alt=""> Customer Support – A dedicated team to assist you at every step of the process.</li>
                                <li><img src="assets/img/icons/check_icon.svg" alt=""> Regulatory Compliance Assurance – Stay compliant with financial regulations, including MiFID II, EMIR, and other global mandates.</li>
                            </ul>
                        </div>

                        <h2>Why Choose Us?</h2>
                        <div class="about-list-two">
                            <ul class="list-wrap">
                                <li><img src="assets/img/icons/check_icon.svg" alt=""> Speed & Efficiency – Get your LEI issued or renewed in just a few hours.</li>
                                <li><img src="assets/img/icons/check_icon.svg" alt=""> Global Reach – We serve clients across multiple industries and countries.</li>
                                <li><img src="assets/img/icons/check_icon.svg" alt=""> Security & Transparency – Your data is protected with the highest security standards.</li>
                                <li><img src="assets/img/icons/check_icon.svg" alt=""> Customer Support – A dedicated team to assist you at every step of the process.</li>
                                <li><img src="assets/img/icons/check_icon.svg" alt=""> User-Friendly Platform – A simple and intuitive system to manage your LEI with ease.</li>
                            </ul>
                        </div>
                        
                        <p>At Bedford Capital, we are committed to providing top-notch LEI services so you can focus on what matters most—growing your business. Let us handle your LEI registration while you stay compliant and worry-free.</p>' !!}

                        
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- about-area-end -->

    <!-- request-area -->
    <section class="request-area request-bg" data-background="assets/img/bg/request_bg.jpg" style="display: none;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-5">
                    <div class="request-content">
                        <h2 class="title">Get your LEI today! <br> Contact us to get started.</h2>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="request-content-right">
                        <div class="request-btn">
                            <a href="/contact/" class="btn">Send a request</a>
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

</main>
<!-- main-area-end -->

@include('partials.footer')

@endsection