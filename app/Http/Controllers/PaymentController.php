<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Quotations;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function store(Request $request, $quotationId)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'payment_method' => 'required|string',
        ]);

        Payment::create([
            'quotation_id' => $quotationId,
            'amount' => $request->amount,
            'payment_method' => $request->payment_method,
            'status' => 'paid',
        ]);

        return back()->with('success', 'Payment added successfully.');
    }
}
