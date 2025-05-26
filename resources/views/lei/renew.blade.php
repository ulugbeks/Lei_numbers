@extends('layouts.app')

@section('title', 'LEI Renewal')

@section('content')

@include('partials.header')

<div class="lei-renewal py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">LEI Renewal</h4>
                    </div>
                    <div class="card-body p-4">
                        @if(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        
                        <form id="renewal-form" action="{{ route('renew.submit') }}" method="POST">
                            @csrf
                            
                            <div class="mb-4">
                                <label for="lei" class="form-label">LEI Code <span class="text-danger">*</span></label>
                                <input type="text" id="lei" name="lei" class="form-control" value="{{ $lei ?? '' }}" maxlength="20" required>
                                <div class="form-text">Enter your 20-character LEI code</div>
                            </div>
                            
                            <div class="mb-4">
                                <label class="form-label">Select Renewal Period <span class="text-danger">*</span></label>
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <div class="card h-100 renewal-option" data-value="1-year">
                                            <div class="card-body text-center">
                                                <h5 class="card-title">1 Year</h5>
                                                <h3 class="card-price">€75</h3>
                                                <input type="radio" name="renewal_period" value="1-year" class="d-none">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card h-100 renewal-option active" data-value="3-years">
                                            <div class="card-body text-center">
                                                <h5 class="card-title">3 Years</h5>
                                                <h3 class="card-price">€165</h3>
                                                <span class="text-primary">Save 27%</span>
                                                <input type="radio" name="renewal_period" value="3-years" class="d-none" checked>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="card h-100 renewal-option" data-value="5-years">
                                            <div class="card-body text-center">
                                                <h5 class="card-title">5 Years</h5>
                                                <h3 class="card-price">€250</h3>
                                                <span class="text-primary">Save 33%</span>
                                                <input type="radio" name="renewal_period" value="5-years" class="d-none">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" id="email" name="email" class="form-control" required>
                                <div class="form-text">We'll send the renewal confirmation to this email</div>
                            </div>
                            
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-lg">Continue to Payment</button>
                            </div>
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
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Plan selection
    const renewalOptions = document.querySelectorAll('.renewal-option');
    
    renewalOptions.forEach(option => {
        option.addEventListener('click', function() {
            // Remove active class from all options
            renewalOptions.forEach(opt => {
                opt.classList.remove('active');
                opt.querySelector('input[type="radio"]').checked = false;
            });
            
            // Add active class to selected option
            this.classList.add('active');
            this.querySelector('input[type="radio"]').checked = true;
        });
    });
});
</script>
@endsection