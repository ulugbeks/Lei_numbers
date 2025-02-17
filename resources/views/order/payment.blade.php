@extends('layouts.app')

@section('content')

@include('partials.header')

<div class="container">
    <h2>You are ordering an LEI number for <strong>{{ $order->company_name }}</strong></h2>

    <div class="order-summary">
        <p><strong>Plan:</strong> {{ $order->plan }} years</p>
        <p><strong>Total Cost:</strong> ${{ $order->total_price }}</p>
    </div>

    <h3>Payment Type</h3>
    <div class="payment-options">
        <button id="pay-with-card" class="payment-btn">Pay with Card</button>
        <button id="pay-with-paypal" class="payment-btn">PayPal</button>
        <button id="pay-with-googlepay" class="payment-btn">Google Pay</button>
    </div>

    <form id="payment-form">
        <div id="card-element"></div>
        <button type="submit" id="pay-now">Pay Now</button>
    </form>
</div>

<script src="https://js.stripe.com/v3/"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var stripe = Stripe("your-stripe-public-key");
        var elements = stripe.elements();
        var card = elements.create("card");
        card.mount("#card-element");

        document.querySelector("#payment-form").addEventListener("submit", function (event) {
            event.preventDefault();

            stripe.createToken(card).then(function (result) {
                if (result.error) {
                    alert(result.error.message);
                } else {
                    fetch("/process-payment", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content")
                        },
                        body: JSON.stringify({
                            stripeToken: result.token.id,
                            order_id: "{{ $order->id }}"
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            window.location.href = "/order-confirmed";
                        } else {
                            alert("Payment failed!");
                        }
                    });
                }
            });
        });
    });
</script>
@endsection
