@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h2>Subscribe to Premium Plan</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form id="payment-form" method="POST" action="{{ route('subscribe') }}">
        @csrf

        <!-- Stripe Card Element -->
            <div class="form-group">
                <label for="card-element">Credit or debit card</label>
                <div id="card-element" class="form-control">
                    <!-- A Stripe Element will be inserted here. -->
                </div>
                <div id="card-errors" class="text-danger mt-2" role="alert"></div>
            </div>

            <button id="submit-button" class="btn btn-primary mt-3">Subscribe</button>
        </form>
    </div>

    <!-- Stripe.js -->
    <script src="https://js.stripe.com/v3/"></script>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const stripe = Stripe("{{ env('STRIPE_KEY') }}"); // یا کلید مستقیم
            const elements = stripe.elements();
            const card = elements.create("card");
            card.mount("#card-element");

            const form = document.getElementById("payment-form");
            const errorElement = document.getElementById("card-errors");
            const submitButton = document.getElementById("submit-button");

            form.addEventListener("submit", async (e) => {
                e.preventDefault();
                submitButton.disabled = true;
                submitButton.textContent = 'Processing...';

                const { paymentMethod, error } = await stripe.createPaymentMethod({
                    type: 'card',
                    card: card,
                });

                if (error) {
                    errorElement.textContent = error.message;
                    submitButton.disabled = false;
                    submitButton.textContent = 'Subscribe';
                } else {
                    const hiddenInput = document.createElement('input');
                    hiddenInput.setAttribute('type', 'hidden');
                    hiddenInput.setAttribute('name', 'payment_method');
                    hiddenInput.setAttribute('value', paymentMethod.id);
                    form.appendChild(hiddenInput);
                    form.submit();
                }
            });
        });
    </script>
@endsection
