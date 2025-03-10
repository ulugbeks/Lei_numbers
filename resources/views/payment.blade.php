@extends('layouts.app')

@section('content')

@include('partials.header')

<div class="payment-page my-5">
    <div class="container">
        <div class="row">
            <!-- Левая колонка -->
            <div class="col-lg-7">
                <div class="order-info bg-white p-4 rounded shadow-sm">
                    <h4 class="mb-4">You are ordering an LEI number for</h4>
                    
                    <!-- ISMA лого и Legal entity name -->
                    <div class="mb-4 company-info">
                        <img src="/assets/img/icons/check_icon.svg" alt="TEST" height="40">
                        <div class="legal-entity-info mt-3">
                            <span class="text-muted">Legal entity name:</span>
                            <h5 class="mb-0">{{ $contact->legal_entity_name }}</h5>
                        </div>
                    </div>

                    <!-- Информационные пункты -->
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

                    <!-- Планы -->
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="plan-option card h-100" id="plan-1-year">
                                <div class="card-body text-center">
                                    <h5 class="card-title">1 year</h5>
                                    <h3 class="card-price">$75</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="plan-option card h-100 active" id="plan-3-years">
                                <div class="card-body text-center">
                                    <h5 class="card-title">3 years</h5>
                                    <h3 class="card-price">$165</h3>
                                    <span class="text-primary">Save 27%</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="plan-option card h-100" id="plan-5-years">
                                <div class="card-body text-center">
                                    <h5 class="card-title">5 years</h5>
                                    <h3 class="card-price">$250</h3>
                                    <span class="text-primary">Save 33%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <!-- Make your choice секция -->
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
                                            <li><i class="fas fa-check text-success me-2"></i>Priority processing</li>
                                            <li><i class="fas fa-check text-success me-2"></i>Digital certificate</li>
                                            <li><i class="fas fa-check text-success me-2"></i>Complimentary LEI tag</li>
                                        </ul>
                                        <div class="fw-bold">$21.00</div>
                                    </div>
                                    <div class="certificate-image">
                                        <img src="/assets/img/icons/certificate.png" alt="Certificate" height="100">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Standard service -->
                        <div class="service-option card" id="service-standard">
                            <div class="card-body">
                                <h6 class="mb-3">Standard service</h6>
                                <div class="fw-bold">Free</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Правая колонка -->
            <div class="col-lg-5">
                <div class="payment-summary bg-white p-4 rounded shadow-sm">
                    <h5 class="mb-4">Total</h5>
                    
                    <!-- Детали цены -->
                    <div class="price-details mb-4">
                        <div class="d-flex justify-content-between mb-2">
                            <span>LEI number registration</span>
                            <span id="plan-amount">${{ number_format($contact->amount, 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Service fee</span>
                            <span id="service-amount">$21.00</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between fw-bold">
                            <span>Total</span>
                            <span id="total-amount">${{ number_format($contact->amount + 21, 2) }}</span>
                        </div>
                    </div>

                    <!-- Дополнительные опции -->
                    <div class="additional-options mb-4">
                        <div class="form-check mb-2">
                            <input type="checkbox" class="form-check-input" id="different-invoice">
                            <label class="form-check-label" for="different-invoice">
                                Send the invoice to a different company
                            </label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="auto-renew" checked>
                            <label class="form-check-label" for="auto-renew">
                                Auto-renew my LEI before expiring
                            </label>
                        </div>
                    </div>

                    <!-- Форма оплаты -->
                    <div class="payment-form">
                        <h5 class="mb-3">Payment Details</h5>
                        <form id="payment-form">
                            <div id="card-element" class="mb-3">
                                <!-- Stripe Card Element будет вставлен здесь -->
                            </div>
                            
                            <div id="card-errors" class="alert alert-danger d-none" role="alert"></div>

                            <button id="submit-payment" class="btn btn-danger w-100">
                                Pay $<span id="total-amount">{{ number_format($contact->amount + 21, 2) }}</span>
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
    console.log('DOM loaded!');

    // Храним состояние выбранных опций
    let state = {
        plan: {
            type: '3-years',
            amount: 165.00
        },
        service: {
            type: 'complete',
            amount: 21.00
        }
    };

    // Цены
    const prices = {
        plans: {
            '1-year': 75.00,
            '3-years': 165.00,
            '5-years': 250.00
        },
        services: {
            complete: 21.00,
            standard: 0.00
        }
    };

    // Планы
    document.querySelectorAll('.plan-option').forEach(plan => {
        plan.addEventListener('click', function() {
            // Убираем активный класс у всех планов
            document.querySelectorAll('.plan-option').forEach(p => {
                p.classList.remove('active');
            });
            
            // Добавляем активный класс кликнутому плану
            this.classList.add('active');
            
            // Обновляем состояние
            const planType = this.id.replace('plan-', '');
            state.plan = {
                type: planType,
                amount: prices.plans[planType]
            };
            
            updateTotals();
        });
    });

    // Сервисы
    document.querySelectorAll('.service-option').forEach(service => {
        service.addEventListener('click', function() {
            // Убираем активный класс у всех сервисов
            document.querySelectorAll('.service-option').forEach(s => {
                s.classList.remove('active');
            });
            
            // Добавляем активный класс кликнутому сервису
            this.classList.add('active');
            
            // Обновляем состояние
            const serviceType = this.id.replace('service-', '');
            state.service = {
                type: serviceType,
                amount: prices.services[serviceType]
            };
            
            updateTotals();
        });
    });

    // Обновление сумм
    function updateTotals() {
        // Обновляем сумму сервиса
        const serviceAmount = document.getElementById('service-amount');
        if (serviceAmount) {
            serviceAmount.textContent = `$${state.service.amount.toFixed(2)}`;
        }

        // Обновляем общую сумму
        const total = state.plan.amount + state.service.amount;
        
        const totalElement = document.getElementById('total-amount');
        if (totalElement) {
            totalElement.textContent = `$${total.toFixed(2)}`;
        }

        // Обновляем сумму на кнопке оплаты
        const payButton = document.getElementById('submit-payment');
        if (payButton) {
            payButton.textContent = `Pay $${total.toFixed(2)}`;
        }
    }

    // Инициализация Stripe
    const stripe = Stripe('{{ config("services.stripe.key") }}');
    const elements = stripe.elements();

    // Создание элемента карты
    const card = elements.create('card', {
        style: {
            base: {
                fontSize: '16px',
                color: '#32325d',
                fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
                '::placeholder': {
                    color: '#aab7c4'
                }
            },
            invalid: {
                color: '#dc3545',
                iconColor: '#dc3545'
            }
        }
    });

    // Монтируем элемент карты
    card.mount('#card-element');

    // Обработка ошибок карты
    card.on('change', function(event) {
        const displayError = document.getElementById('card-errors');
        if (event.error) {
            displayError.classList.remove('d-none');
            displayError.textContent = event.error.message;
        } else {
            displayError.classList.add('d-none');
            displayError.textContent = '';
        }
    });

    // Обработка отправки формы
    const form = document.getElementById('payment-form');
    if (form) {
        form.addEventListener('submit', async function(e) {
            e.preventDefault();
            const submitButton = document.getElementById('submit-payment');
            
            submitButton.disabled = true;
            submitButton.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Processing...';

            try {
                const {paymentIntent, error} = await stripe.confirmCardPayment('{{ $clientSecret }}', {
                    payment_method: {
                        card: card,
                        billing_details: {
                            email: '{{ $contact->email }}'
                        }
                    },
                    metadata: {
                        plan_type: state.plan.type,
                        service_type: state.service.type,
                        total_amount: (state.plan.amount + state.service.amount).toFixed(2)
                    }
                });

                if (error) {
                    const errorElement = document.getElementById('card-errors');
                    errorElement.classList.remove('d-none');
                    errorElement.textContent = error.message;
                    submitButton.disabled = false;
                    submitButton.innerHTML = 'PAY NOW';
                } else if (paymentIntent.status === 'succeeded') {
                    window.location.href = '/payment/success/' + paymentIntent.id;
                }
            } catch (error) {
                console.error('Payment error:', error);
                const errorElement = document.getElementById('card-errors');
                errorElement.classList.remove('d-none');
                errorElement.textContent = 'An error occurred. Please try again.';
                submitButton.disabled = false;
                submitButton.innerHTML = 'PAY NOW';
            }
        });
    }

    // Инициализация начальных состояний
    updateTotals();
});
</script>
@endsection