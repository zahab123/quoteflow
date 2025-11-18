<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Clients;
use App\Models\Quotations;
use App\Models\QuotationItems;
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

        foreach ($request->items as $item) {
            $itemTotal = ($item['qty'] * $item['unit_price']) + ($item['tax'] ?? 0) - ($item['discount'] ?? 0);
            $total += $itemTotal;
            $taxTotal += ($item['tax'] ?? 0);
            $discountTotal += ($item['discount'] ?? 0);
        }

        $quotation = Quotations::create([
            'user_id' => Auth::id(),
            'client_id' => $request->client_id,
            'title' => $request->title,
            'total' => $total,
            'tax' => $taxTotal,
            'discount' => $discountTotal,
            'status' => 'draft',
            'notes' => $request->notes ?? null
        ]);

        foreach ($request->items as $item) {
            $itemTotal = ($item['qty'] * $item['unit_price']) + ($item['tax'] ?? 0) - ($item['discount'] ?? 0);

            QuotationItems::create([
                'quotation_id' => $quotation->id,
                'description' => $item['description'],
                'qty' => $item['qty'],
                'unit_price' => $item['unit_price'],
                'tax' => $item['tax'] ?? 0,
                'discount' => $item['discount'] ?? 0,
                'total' => $itemTotal
            ]);
        }

        return back()->with('success', 'Quotation added successfully!');
    }

    // List all quotations
    public function quotationlist()
    {
        $quotations = Quotations::with('items', 'client')->get();
        return view('quotationlist', compact('quotations'));
    }

    // View a specific quotation
    public function view($id)
    {
        $quotation = Quotations::with('client', 'items')->findOrFail($id);
        return view('view', compact('quotation'));
    }

    // Delete a specific quotation
    public function delete($id)
    {
        $quotation = Quotations::find($id);

        if (!$quotation) {
            return redirect()->back()->with('error', 'Quotation not found.');
        }

        $quotation->items()->delete();
        $quotation->delete();

        return redirect()->back()->with('success', 'Quotation deleted successfully.');
    }

    // Edit a quotation
    public function edit($id)
    {
        $quotation = Quotations::with('items')->find($id);
        $clients = Clients::all();

        if (!$quotation) {
            return redirect()->route('quotationlist')->with('error', 'Quotation not found.');
        }

        return view('editquotation', compact('quotation', 'clients'));
    }

    // Update a quotation
    public function update(Request $request, $id)
    {
        $quotation = Quotations::with('items')->findOrFail($id);


        $total = 0;
        $taxTotal = 0;
        $discountTotal = 0;

        // Delete old items
        $quotation->items()->delete();

        // Save new items and calculate totals
        foreach ($request->items as $item) {
            $itemTotal = ($item['qty'] * $item['unit_price']) + ($item['tax'] ?? 0) - ($item['discount'] ?? 0);

            QuotationItems::create([
                'quotation_id' => $quotation->id,
                'description' => $item['description'],
                'qty' => $item['qty'],
                'unit_price' => $item['unit_price'],
                'tax' => $item['tax'] ?? 0,
                'discount' => $item['discount'] ?? 0,
                'total' => $itemTotal
            ]);

            $total += $itemTotal;
            $taxTotal += $item['tax'] ?? 0;
            $discountTotal += $item['discount'] ?? 0;
        }

        // Update quotation
        $quotation->update([
            'client_id' => $request->client_id,
            'title' => $request->title,
            'total' => $total,
            'tax' => $taxTotal,
            'discount' => $discountTotal,
            'notes' => $request->notes ?? null
        ]);

        return redirect()->route('quotationlist')->with('success', 'Quotation updated successfully!');
    }
}
