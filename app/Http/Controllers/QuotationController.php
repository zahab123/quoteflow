<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Models\Clients;
use App\Models\Quotations;
use App\Models\QuotationItems;
use App\Mail\QuotationMail;
use App\Models\QuotationStatusLog;
use Illuminate\Support\Facades\Auth;
use Dompdf\Dompdf;
use Barryvdh\DomPDF\Facade\Pdf;


class QuotationController extends Controller
{
    // Show create quotation page
    public function create()
    {
        $clients = Clients::all();
        return view('quotations', compact('clients'));
    }

    public function addquotation(Request $request)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'title' => 'required|string|max:255',
            'items' => 'required|array',
            'status' => 'required|in:sent,draft'
        ]);

        $total = 0;
        $taxTotal = 0;
        $discountTotal = 0;

        foreach ($request->items as $item) {
            $itemTotal = ($item['qty'] * $item['unit_price']) + ($item['tax'] ?? 0) - ($item['discount'] ?? 0);
            $total += $itemTotal;
            $taxTotal += ($item['tax'] ?? 0);
            $discountTotal += ($item['discount'] ?? 0);
        }

        // Create quotation
        $quotation = Quotations::create([
            'user_id' => Auth::id(),
            'client_id' => $request->client_id,
            'title' => $request->title,
            'total' => $total,
            'tax' => $taxTotal,
            'discount' => $discountTotal,
            'status' => $request->status,
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

        QuotationStatusLog::create([
            'quotation_id' => $quotation->id,
            'status' => $request->status,
            'changed_at' => now(),
            'remarks' => null
        ]);

        return redirect()->route('quotationlist')->with('success', 'Quotation added successfully!');
    }

    // Update a quotation
    public function update(Request $request, $id)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'title' => 'required|string|max:255',
            'items' => 'required|array',
            'status' => 'required|in:sent,draft'
        ]);

        $quotation = Quotations::with('items')->findOrFail($id);

        $total = 0;
        $taxTotal = 0;
        $discountTotal = 0;

        $quotation->items()->delete();
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

        $quotation->update([
            'client_id' => $request->client_id,
            'title' => $request->title,
            'total' => $total,
            'tax' => $taxTotal,
            'discount' => $discountTotal,
            'status' => $request->status,
            'notes' => $request->notes ?? null
        ]);

        QuotationStatusLog::create([
            'quotation_id' => $quotation->id,
            'status' => $request->status,
            'changed_at' => now(),
            'remarks' => null
        ]);

        return redirect()->route('quotationlist')->with('success', 'Quotation updated successfully!');
    }

    // List all quotations with search & filter
    public function quotationlist(Request $request)
    {
        $query = Quotations::with('items', 'client');
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%$search%")
                  ->orWhereHas('client', function($q2) use ($search) {
                      $q2->where('name', 'like', "%$search%");
                  });
            });
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $quotations = $query->orderBy('created_at', 'desc')->paginate(12);

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

    // Copy a quotation
    public function copy($id)
    {
        $original = Quotations::with('items')->findOrFail($id);
        $copy = $original->replicate(); 
        $copy->status = 'Draft';       
        $copy->save();
        foreach ($original->items as $item) {
            $copy->items()->create($item->toArray());
        }

        return redirect()->route('quotationlist')->with('success', 'Quotation copied successfully!');
    }

    // dowload pdf
    public function download($id)
    {
        $quotation = Quotations::with('items', 'client')->findOrFail($id);
        $pdf = Pdf::loadView('quotations.pdf', compact('quotation'))
                ->setPaper('a4', 'portrait');
        return $pdf->download('quotation_'.$quotation->id.'.pdf');
    }


    // send mail
   public function sendEmail($id)
    {
        $quotation = Quotation::findOrFail($id);
        $pdf = Pdf::loadView('quotations.pdf', ['quotation' => $quotation]);
        $pdfPath = storage_path("app/quotations/quotation_{$quotation->id}.pdf");
        $pdf->save($pdfPath);
        Mail::to($quotation->client_email)->send(new QuotationMail($quotation, null, true));
        return back()->with('success', 'Email sent successfully!');
    }
    
}
