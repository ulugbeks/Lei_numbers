@extends('layouts.app')

@section('title', 'LEI Transfer Request Confirmation')

@section('content')

@include('partials.header')

<div class="transfer-confirmation py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-body text-center p-5">
                        <div class="mb-4">
                            <i class="fas fa-check-circle text-success" style="font-size: 64px;"></i>
                        </div>
                        
                        <h1 class="card-title mb-4">Transfer Request Submitted!</h1>
                        
                        <p class="card-text mb-4">
                            Your LEI transfer request has been submitted successfully.
                        </p>
                        
                        <div class="alert alert-info mb-4">
                            <h5 class="alert-heading">What happens next?</h5>
                            <p>Our team will review your transfer request and contact you shortly to complete the process.</p>
                            <hr>
                            @if(session('lei'))
                            <p class="mb-0">LEI Code: <strong>{{ session('lei') }}</strong></p>
                            @endif
                            @if(session('company'))
                            <p class="mb-0">Entity: <strong>{{ session('company') }}</strong></p>
                            @endif
                        </div>
                        
                        <div class="mt-4">
                            <a href="{{ route('home') }}" class="btn btn-primary btn-lg">Return to Homepage</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('partials.footer')

@endsection