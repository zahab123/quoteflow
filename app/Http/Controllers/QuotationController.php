<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Clients;
use App\Models\Quotations;
use App\Models\Quotation_items; // correct import
use Illuminate\Support\Facades\Auth;

class QuotationController extends Controller
{
    // Show create quotation page
    public function create()
    {
        $clients = Clients::all();
        return view('quotations', compact('clients'));
    }

    // Add quotation function
    public function addquotation(Request $request)
    {
        $total = 0;
        $taxTotal = 0;
        $discountTotal = 0;

        // Calculate totals
        foreach ($request->items as $item) {
            $itemTotal = $item['qty'] * $item['unit_price'];
            $itemTax = $itemTotal * ($item['tax'] ?? 0) / 100;
            $itemDiscount = $itemTotal * ($item['discount'] ?? 0) / 100;

            $total += $itemTotal + $itemTax - $itemDiscount;
            $taxTotal += $itemTax;
            $discountTotal += $itemDiscount;
        }

        // Save quotation
        $quotation = Quotations::create([
            'user_id' => Auth::id(),
            'client_id' => $request->client_id,
            'title' => $request->title,
            'total' => $total,
            'tax' => $taxTotal,
            'discount' => $discountTotal,
            'status' => 'draft'
        ]);

        // Save quotation items
        foreach ($request->items as $item) {
            $itemTotal = $item['qty'] * $item['unit_price'];
            $itemTax = $itemTotal * ($item['tax'] ?? 0) / 100;
            $itemDiscount = $itemTotal * ($item['discount'] ?? 0) / 100;

            Quotation_items::create([ // use correct model name
                'quotation_id' => $quotation->id,
                'description' => $item['description'],
                'qty' => $item['qty'],
                'unit_price' => $item['unit_price'],
                'tax' => $item['tax'] ?? 0,
                'discount' => $item['discount'] ?? 0,
                'total' => $itemTotal + $itemTax - $itemDiscount
            ]);
        }

        return back()->with('success', 'Quotation added successfully!');

    }

        public function quotationlist()
        {
            $quotations = Quotations::all();
            return view('quotationlist', compact('quotations'));
        }

}
