@extends('layouts.app')

@section('title', 'Payment for LEI Registration')

@section('content')

@include('partials.header')

<div class="payment-page my-5">
    <div class="container">
        <div class="row">
            <!-- Left column - Order information -->
            <div class="col-lg-7">
                <div class="order-info bg-white p-4 rounded shadow-sm mb-4">
                    <h4 class="mb-4">You are ordering an LEI number for</h4>
                    
                    <!-- Company info -->
                    <div class="mb-4 company-info">
                        <div class="legal-entity-info mt-3">
                            <span class="text-muted">Legal entity name:</span>
                            <h5 class="mb-0">{{ $contact->legal_entity_name }}</h5>
                        </div>
                    </div>

                    <!-- Benefits list -->
                    <div class="benefits mb-4">
                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-check text-success me-3"></i>
                            <span>We'll begin processing your LEI application once payment is received</span>
                        </div>
                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-check text-success me-3"></i>
                            <span>95% of LEI numbers are issued in less than 24 hours</span>
                        </div>
                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-check text-success me-3"></i>
                            <span>Your LEI number will be sent to {{ $contact->email }}</span>
                        </div>
                    </div>

                    <!-- Plans -->
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="plan-option card h-100 {{ $contact->selected_plan === '1-year' ? 'active' : '' }}" id="plan-1-year">
                                <div class="card-body text-center">
                                    <h5 class="card-title">1 year</h5>
                                    <h3 class="card-price">£75</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="plan-option card h-100 {{ $contact->selected_plan === '3-years' ? 'active' : '' }}" id="plan-3-years">
                                <div class="card-body text-center">
                                    <h5 class="card-title">3 years</h5>
                                    <h3 class="card-price">£165</h3>
                                    <span class="text-primary">Save 27%</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="plan-option card h-100 {{ $contact->selected_plan === '5-years' ? 'active' : '' }}" id="plan-5-years">
                                <div class="card-body text-center">
                                    <h5 class="card-title">5 years</h5>
                                    <h3 class="card-price">£250</h3>
                                    <span class="text-primary">Save 33%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <!-- Service options -->
                    <div class="make-choice mb-4">
                        <h5 class="mb-3">Make your choice</h5>
                        
                        <!-- Complete service -->
                        <div class="service-option card mb-3" id="service-complete">
                            <div class="card-body">
                                <div class="d-flex justify-content-between">
                                    <div>
                                        <span class="badge bg-danger mb-2">Most popular</span>
                                        <h6 class="mb-3">Complete service</h6>
                                        <ul class="list-unstyled mb-3">
                                            <li><i class="fas fa-check text-success me-2"></i> Priority processing</li>
                                            <li><i class="fas fa-check text-success me-2"></i> Digital certificate</li>
                                            <li><i class="fas fa-check text-success me-2"></i> Complimentary LEI tag</li>
                                        </ul>
                                        <div class="fw-bold">£21.00</div>
                                    </div>
                                    <!--<div class="certificate-image">-->
                                    <!--    <img src="{{ asset('assets/img/icons/check_icon.svg') }}" alt="Certificate" height="60">-->
                                    <!--</div>-->
                                </div>
                            </div>
                        </div>

                        <!-- Standard service -->
                        <div class="service-option card active" id="service-standard">
                            <div class="card-body">
                                <h6 class="mb-3">Standard service</h6>
                                <div class="fw-bold">Free</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right column - Payment form -->
            <div class="col-lg-5">
                <div class="payment-summary bg-white p-4 rounded shadow-sm">
                    <h5 class="mb-4">Total</h5>
                    
                    <!-- Price details -->
                    <div class="price-details mb-4">
                        <div class="d-flex justify-content-between mb-2">
                            <span>LEI number registration</span>
                            <span id="plan-amount">£{{ $amount }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Service fee</span>
                            <span id="service-amount">£0.00</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between fw-bold">
                            <span>Total</span>
                            <span id="total-amount">£{{ $amount }}</span>
                        </div>
                    </div>

                    <!-- Additional options -->
                    <div class="additional-options mb-4">
                        <div class="form-check mb-2">
                            <input type="checkbox" class="form-check-input" id="auto-renew" checked>
                            <label class="form-check-label" for="auto-renew">
                                Auto-renew my LEI before expiring
                            </label>
                        </div>
                    </div>

                    <!-- Payment form -->
                    <div class="payment-form">
                        <h5 class="mb-3">Payment Details</h5>
                        <form id="payment-form">
                            <div class="payment-method-selector mb-3">
                                <div class="btn-group w-100" role="group">
                                    <button type="button" class="btn btn-outline-primary active" data-method="card">
                                        <i class="far fa-credit-card"></i> Card
                                    </button>
                                    <!-- <button type="button" class="btn btn-outline-primary" data-method="paypal">
                                        <i class="fab fa-paypal"></i> PayPal
                                    </button> -->
                                </div>
                            </div>
                            
                            <div class="card-payment-method">
                                <div id="card-element" class="mb-3 p-3 border rounded">
                                    <!-- Stripe Card Element will be inserted here -->
                                </div>
                                
                                <div id="card-errors" class="alert alert-danger d-none" role="alert"></div>
                            </div>
                            
                            <div class="paypal-payment-method d-none">
                                <div class="alert alert-info">
                                    You will be redirected to PayPal to complete your payment.
                                </div>
                            </div>

                            <button id="submit-payment" class="btn btn-primary w-100 mt-3">
                                Pay <span id="button-amount">£ {{ $amount }}</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('partials.footer')

@endsection

@section('scripts')
<script src="https://js.stripe.com/v3/"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Stripe
    const stripe = Stripe('{{ config("services.stripe.key") }}');
    const elements = stripe.elements();
    const clientSecret = '{{ $clientSecret }}';
    
    // Store state
    let state = {
        plan: '{{ $contact->selected_plan }}',
        planAmount: {{ $amount }},
        serviceType: 'standard',
        serviceAmount: 0,
        paymentMethod: 'card'
    };
    
    // Calculate total
    function calculateTotal() {
        return state.planAmount + state.serviceAmount;
    }
    
    // Update displayed amounts
    function updateAmounts() {
        document.getElementById('plan-amount').textContent = `£${state.planAmount.toFixed(2)}`;
        document.getElementById('service-amount').textContent = `£${state.serviceAmount.toFixed(2)}`;
        document.getElementById('total-amount').textContent = `£${calculateTotal().toFixed(2)}`;
        document.getElementById('button-amount').textContent = `£${calculateTotal().toFixed(2)}`;
    }

    // Create and add styles for plan options and checkboxes
    const style = document.createElement('style');
    style.textContent = `
        .plan-option {
            position: relative;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        
        .plan-option:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        
        .plan-option.active {
            border-color: #213460;
            background-color: rgba(13, 110, 253, 0.05);
        }
        
        .plan-checkbox {
            position: absolute;
            top: 10px;
            right: 10px;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background-color: #4169E1;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            visibility: hidden;
        }
        
        .plan-option.active .plan-checkbox {
            visibility: visible;
        }
        
        .plan-checkbox i {
            font-size: 18px;
        }
        
        .service-option {
            position: relative;
            cursor: pointer;
        }
    `;
    document.head.appendChild(style);
    
    // Add checkbox elements to each plan option
    document.querySelectorAll('.plan-option').forEach(option => {
        const checkbox = document.createElement('div');
        checkbox.className = 'plan-checkbox';
        checkbox.innerHTML = '<i class="fas fa-check"></i>';
        option.appendChild(checkbox);
    });

    // Plan option selection - Add event listeners to plan options
    document.querySelectorAll('.plan-option').forEach(option => {
        option.addEventListener('click', function() {
            // Remove active class from all options
            document.querySelectorAll('.plan-option').forEach(o => {
                o.classList.remove('active');
            });
            
            // Add active class to clicked option
            this.classList.add('active');
            
            // Update state
            const planId = this.id.replace('plan-', '');
            state.plan = planId;
            
            // Set plan amount based on selected plan
            if (planId === '1-year') {
                state.planAmount = 75;
            } else if (planId === '3-years') {
                state.planAmount = 165;
            } else if (planId === '5-years') {
                state.planAmount = 250;
            }
            
            // Update all amounts
            updateAmounts();
        });
    });

    // Create card element
    const cardElement = elements.create('card', {
        style: {
            base: {
                fontSize: '16px',
                color: '#32325d',
                fontFamily: '-apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif',
                '::placeholder': {
                    color: '#aab7c4'
                }
            },
            invalid: {
                color: '#fa755a',
                iconColor: '#fa755a'
            }
        }
    });
    
    // Mount card element
    cardElement.mount('#card-element');
    
    // Handle card errors
    cardElement.on('change', function(event) {
        const displayError = document.getElementById('card-errors');
        if (event.error) {
            displayError.textContent = event.error.message;
            displayError.classList.remove('d-none');
        } else {
            displayError.textContent = '';
            displayError.classList.add('d-none');
        }
    });

    // Service option selection
    document.querySelectorAll('.service-option').forEach(option => {
        option.addEventListener('click', function() {
            // Remove active class from all options
            document.querySelectorAll('.service-option').forEach(o => {
                o.classList.remove('active');
            });
            
            // Add active class to clicked option
            this.classList.add('active');
            
            // Update state
            const serviceType = this.id.replace('service-', '');
            state.serviceType = serviceType;
            state.serviceAmount = serviceType === 'complete' ? 21 : 0;
            
            // Update amounts
            updateAmounts();
        });
    });
    
    // Payment method selection
    document.querySelectorAll('.payment-method-selector button').forEach(button => {
        button.addEventListener('click', function() {
            // Remove active class from all buttons
            document.querySelectorAll('.payment-method-selector button').forEach(b => {
                b.classList.remove('active');
            });
            
            // Add active class to clicked button
            this.classList.add('active');
            
            // Update state
            state.paymentMethod = this.getAttribute('data-method');
            
            // Toggle payment method sections
            if (state.paymentMethod === 'card') {
                document.querySelector('.card-payment-method').classList.remove('d-none');
                document.querySelector('.paypal-payment-method').classList.add('d-none');
            } else {
                document.querySelector('.card-payment-method').classList.add('d-none');
                document.querySelector('.paypal-payment-method').classList.remove('d-none');
            }
        });
    });

    // Handle form submission
    const form = document.getElementById('payment-form');
    
    form.addEventListener('submit', async function(event) {
        event.preventDefault();
        
        const submitButton = document.getElementById('submit-payment');
        submitButton.disabled = true;
        submitButton.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Processing...';
        
        if (state.paymentMethod === 'card') {
            // Process card payment
            const { error, paymentIntent } = await stripe.confirmCardPayment(clientSecret, {
                payment_method: {
                    card: cardElement,
                    billing_details: {
                        email: '{{ $contact->email }}'
                    }
                }
            });
            
            if (error) {
                // Show error message
                const errorElement = document.getElementById('card-errors');
                errorElement.textContent = error.message;
                errorElement.classList.remove('d-none');
                submitButton.disabled = false;
                submitButton.innerHTML = 'Pay £' + calculateTotal().toFixed(2);
            } else if (paymentIntent.status === 'succeeded') {
                // Payment successful, redirect to success page
                window.location.href = '{{ route("payment.success", ["paymentIntent" => "_ID_"]) }}'.replace('_ID_', paymentIntent.id);
            }
        } else {
            // Handle PayPal option (for future implementation)
            alert('PayPal integration coming soon!');
            submitButton.disabled = false;
            submitButton.innerHTML = 'Pay £' + calculateTotal().toFixed(2);
        }
    });
});
</script>
@endsection