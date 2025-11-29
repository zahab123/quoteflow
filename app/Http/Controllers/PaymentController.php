<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Charge;

class PaymentController extends Controller
{
    public function showPaymentForm()
    {
        return view('payment.form');
    }

    public function processStripePayment(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $charge = Charge::create([
            'amount' => $request->amount * 100, // amount in cents
            'currency' => 'usd',
            'source' => $request->stripeToken,
            'description' => 'Quotation Payment'
        ]);

        // Optionally, store payment info in your DB here

        return back()->with('success', 'Payment successful!');
    }
}
