<?php

namespace App\Http\Controllers;   // <-- REQUIRED!

use App\Models\Quotations;
use App\Models\QuotationStatusLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class QuotationStatusController extends Controller
{
    // Change the status of a quotation
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:sent,viewed,accepted,declined',
            'remarks' => 'nullable|string'
        ]);

        $quotation = Quotations::findOrFail($id);

        // Update the quotation's current status
        $quotation->status = $request->status;
        $quotation->save();

        // Log the status change
        QuotationStatusLog::create([
            'quotation_id' => $quotation->id,
            'status' => $request->status,
            'changed_at' => now(),
            'remarks' => $request->remarks
        ]);

        return redirect()->back()->with('success', 'Quotation status updated successfully!');
    }

    // View status history of a quotation
    public function history($id)
    {
        $quotation = Quotations::with('statusLogs')->findOrFail($id);
        return view('quotation_status_history', compact('quotation'));
    }
}
