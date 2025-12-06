<?php

namespace App\Http\Controllers;

use App\Models\Quotations;
use App\Models\QuotationStatusLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuotationStatusController extends Controller
{
    // update the status
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:sent,viewed,accepted,declined',
            'remarks' => 'nullable|string'
        ]);

        $quotation = Quotations::where('user_id', Auth::id())->findOrFail($id);

        $quotation->status = $request->status;
        $quotation->save();

        QuotationStatusLog::create([
            'quotation_id' => $quotation->id,
            'status' => $request->status,
            'changed_at' => now(),
            'remarks' => $request->remarks
        ]);

        return redirect()->back()->with('success', 'Quotation status updated successfully!');
    }
    // TAke history of Status of current quotation
    public function history($id)
    {
        $quotation = Quotations::with('statusLogs')
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('quotation_status_history', compact('quotation'));
    }
    
}