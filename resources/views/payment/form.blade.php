<!DOCTYPE html>
<html>
<head>
    <title>Stripe Payment</title>
    <script src="https://checkout.stripe.com/checkout.js"></script>
</head>
<body>
    @if(session('success'))
        <p>{{ session('success') }}</p>
    @endif

    <form action="{{ route('payment.stripe') }}" method="POST">
        @csrf
        <input type="text" name="amount" placeholder="Enter Amount" required>

        <script
            src="https://checkout.stripe.com/checkout.js" class="stripe-button"
            data-key="{{ env('STRIPE_KEY') }}"
            data-name="Quotation Payment"
            data-description="Pay for Quotation"
            data-currency="usd">
        </script>
    </form>
</body>
</html>
