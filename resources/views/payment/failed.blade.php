@extends('layouts.app')

@section('title', 'Payment Failed')

@section('content')

@include('partials.header')

<div class="payment-failed py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-body text-center p-5">
                        <div class="mb-4">
                            <i class="fas fa-times-circle text-danger" style="font-size: 64px;"></i>
                        </div>
                        
                        <h1 class="card-title mb-4">Payment Failed</h1>
                        
                        <p class="card-text mb-4">
                            We're sorry, but there was a problem processing your payment.
                        </p>
                        
                        <div class="alert alert-warning mb-4">
                            <h5 class="alert-heading">Possible Reasons</h5>
                            <ul class="text-start mb-0">
                                <li>Your card was declined by the issuing bank</li>
                                <li>Insufficient funds in your account</li>
                                <li>Incorrect card details were entered</li>
                                <li>Your card doesn't support online or international transactions</li>
                                <li>Technical issues with the payment processor</li>
                            </ul>
                        </div>
                        
                        <div class="mt-4">
                            <a href="{{ url()->previous() }}" class="btn btn-primary btn-lg me-2">Try Again</a>
                            <a href="{{ route('contact') }}" class="btn btn-outline-secondary btn-lg">Contact Support</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('partials.footer')

@endsection