@extends('layouts.app')

@section('title', 'Home')

@section('content')

@include('partials.header')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Payment Details</div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <h3>Order Summary</h3>
                    
                    @if(isset($contact))
                        <div class="order-details">
                            <p><strong>Order ID:</strong> {{ $contact->id }}</p>
                            <p><strong>Service:</strong> {{ ucfirst($contact->type ?? 'LEI Registration') }}</p>
                            <p><strong>Plan:</strong> {{ $contact->selected_plan ?? '1 Year' }}</p>
                            
                            @php
                                $amount = 75; // Default amount
                                
                                if(isset($contact->selected_plan)) {
                                    switch($contact->selected_plan) {
                                        case '1-year':
                                            $amount = 75;
                                            break;
                                        case '3-years':
                                            $amount = 165;
                                            break;
                                        case '5-years':
                                            $amount = 250;
                                            break;
                                    }
                                }
                            @endphp
                            
                            <p><strong>Amount:</strong> €{{ $amount }}</p>
                        </div>
                        
                        <hr>
                        
                        <h3>Payment Method</h3>
                        <form id="payment-form" action="{{ route('payment.success', ['paymentIntent' => 'test']) }}" method="GET">
                            <!-- Simulated payment form for testing -->
                            <div class="form-group">
                                <label for="card_number">Card Number</label>
                                <input type="text" class="form-control" id="card_number" placeholder="4242 4242 4242 4242">
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="expiry">Expiry (MM/YY)</label>
                                        <input type="text" class="form-control" id="expiry" placeholder="12/25">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="cvc">CVC</label>
                                        <input type="text" class="form-control" id="cvc" placeholder="123">
                                    </div>
                                </div>
                            </div>
                            
                            <button type="submit" class="btn btn-primary btn-block mt-4">Pay €{{ $amount }}</button>
                        </form>
                    @else
                        <div class="alert alert-warning">
                            Order information not available. Please try again.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@include('partials.footer')

@endsection