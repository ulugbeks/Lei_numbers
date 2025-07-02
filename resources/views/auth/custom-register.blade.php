@extends('layouts.app')

@section('title', 'Register')

@section('content')

@include('partials.header')

<main class="fix">
    <!-- breadcrumb-area -->
    <section class="breadcrumb-area breadcrumb-bg" data-background="{{ asset('assets/img/bg/breadcrumb_bg.jpg') }}">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-content">
                        <h2 class="title">Register</h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Register</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <div class="breadcrumb-shape-wrap">
            <img src="{{ asset('assets/img/images/breadcrumb_shape01.png') }}" alt="">
            <img src="{{ asset('assets/img/images/breadcrumb_shape02.png') }}" alt="">
        </div>
    </section>
    <!-- breadcrumb-area-end -->

    <!-- register-area -->
    <section class="register-area section-py-120">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="register-form-wrap">
                        <h3 class="title mb-4">Create Your Account</h3>
                        
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('register') }}" method="POST" class="register-form">
                            @csrf
                            
                            <div class="form-grp">
                                <label for="name">Full Name <span class="required">*</span></label>
                                <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus>
                            </div>
                            
                            <div class="form-grp">
                                <label for="email">Email Address <span class="required">*</span></label>
                                <input type="email" id="email" name="email" value="{{ old('email') }}" required>
                            </div>
                            
                            <div class="form-grp">
                                <label for="password">Password <span class="required">*</span></label>
                                <input type="password" id="password" name="password" required>
                                <small class="form-text text-muted">Password must be at least 8 characters long</small>
                            </div>
                            
                            <div class="form-grp">
                                <label for="password_confirmation">Confirm Password <span class="required">*</span></label>
                                <input type="password" id="password_confirmation" name="password_confirmation" required>
                            </div>
                            
                            <div class="form-grp">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="terms" name="terms" required>
                                    <label class="form-check-label" for="terms">
                                        I agree to the <a href="{{ route('terms-and-conditions') }}">Terms & Conditions</a> and 
                                        <a href="{{ route('privacy-policy') }}">Privacy Policy</a>
                                    </label>
                                </div>
                            </div>
                            
                            <button type="submit" class="btn btn-primary">Register</button>
                            
                            <div class="text-center mt-3">
                                <p>Already have an account? <a href="{{ route('login') }}">Login here</a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- register-area-end -->
</main>

@include('partials.footer')

@endsection