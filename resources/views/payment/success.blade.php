@extends('layouts.app')

@section('title', 'Payment Successful')

@section('content')

@include('partials.header')

<div class="payment-success py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-body text-center p-5">
                        <div class="mb-4">
                            <i class="fas fa-check-circle text-success" style="font-size: 64px;"></i>
                        </div>
                        
                        <h1 class="card-title mb-4">Payment Successful!</h1>
                        
                        <p class="card-text mb-4">
                            Thank you for your payment. Your LEI registration process has been started.
                        </p>
                        
                        <div class="alert alert-info mb-4">
                            <h5 class="alert-heading">What happens next?</h5>
                            <p>We've received your payment and will now begin processing your LEI registration.</p>
                            <hr>
                            <p class="mb-0">You will receive an email confirmation at <strong>{{ $contact->email }}</strong> with your LEI details once the registration is complete (typically within 24 hours).</p>
                        </div>
                        
                        <div class="order-details my-4 text-start p-4 bg-light rounded">
                            <h5 class="mb-3">Order Details</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Order ID:</strong> {{ $contact->id }}</p>
                                    <p><strong>Legal Entity:</strong> {{ $contact->legal_entity_name }}</p>
                                    <p><strong>Plan:</strong> {{ $contact->selected_plan }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong>Date:</strong> {{ now()->format('Y-m-d') }}</p>
                                    <p><strong>Payment ID:</strong> {{ substr($paymentIntent->id, 0, 8) }}</p>
                                    <p><strong>Amount:</strong> €{{ number_format($paymentIntent->amount / 100, 2) }}</p>
                                </div>
                            </div>
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