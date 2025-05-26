@extends('layouts.app')

@section('title', 'Bulk LEI Registration Request Confirmation')

@section('content')

@include('partials.header')

<div class="bulk-confirmation py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-body text-center p-5">
                        <div class="mb-4">
                            <i class="fas fa-check-circle text-success" style="font-size: 64px;"></i>
                        </div>
                        
                        <h1 class="card-title mb-4">Bulk Registration Request Submitted!</h1>
                        
                        <p class="card-text mb-4">
                            Thank you for your interest in bulk LEI registration. Your request has been submitted successfully.
                        </p>
                        
                        <div class="alert alert-info mb-4">
                            <h5 class="alert-heading">What happens next?</h5>
                            <p>Our team will review your bulk registration request and contact you shortly to discuss your requirements and provide a customized solution.</p>
                            <hr>
                            <p class="mb-0">We typically respond to bulk registration requests within 1 business day.</p>
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