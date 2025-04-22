@extends('layouts.app')

@section('title', 'Home')

@section('content')

@include('partials.header')
<main>
    <!-- breadcrumb-area -->
    <section class="breadcrumb-area breadcrumb-bg" data-background="assets/img/bg/breadcrumb_bg.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-content">
                        <h2 class="title">{{ $page->title ?? 'Privacy Policy' }}</h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ $page->title }}</li>
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

    <!-- Page Content -->
    <section class="about-area pt-100 pb-100">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="about-content">
                        {!! $content['main_content'] ?? '' !!}
                    </div>
                </div>
            </div>
            
        </div>
    </section>
    <!-- Page Content End -->
</main>

@include('partials.footer')
@endsection