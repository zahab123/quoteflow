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
use App\Models\Company; 
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;



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
        $itemTotal = ($item['qty'] * $item['unit_price']) - ($item['discount'] ?? 0) + ($item['tax'] ?? 0);
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
        'status' => $request->status,
        'notes' => $request->notes ?? null
    ]);

    foreach ($request->items as $item) {
        $itemTotal = ($item['qty'] * $item['unit_price']) + ($item['tax'] ?? 0) - ($item['discount'] ?? 0);

        QuotationItems::create([
            'quotation_id' => $quotation->id,
            'description' => $item['description'] ?? $aiDescription, // ← AI description
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
public function update(Request $request, $id)
{
    // Validate main quotation data
    $request->validate([
        'client_id' => 'required|exists:clients,id',
        'title' => 'required|string|max:255',
        'notes' => 'nullable|string',
        'items' => 'required|array',
        'items.*.description' => 'required|string|max:255',
        'items.*.qty' => 'required|numeric|min:1',
        'items.*.unit_price' => 'required|numeric|min:0',
        'items.*.tax' => 'nullable|numeric|min:0',
        'items.*.discount' => 'nullable|numeric|min:0',
    ]);

    DB::transaction(function () use ($request, $id) {
        $quotation = Quotations::with('items')->findOrFail($id);
        $quotation->client_id = $request->client_id;
        $quotation->title = $request->title;
      
        $quotation->save();

        $existingItemIds = $quotation->items->pluck('id')->toArray();
        $submittedItemIds = [];

        foreach ($request->items as $index => $itemData) {
            $total = ($itemData['qty'] * $itemData['unit_price']) + floatval($itemData['tax'] ?? 0) - floatval($itemData['discount'] ?? 0);

            if (isset($itemData['id'])) {
                $item = QuotationItems::find($itemData['id']);
                if ($item) {
                    $item->update([
                        'description' => $itemData['description'],
                        'qty' => intval($itemData['qty']),
                        'unit_price' => floatval($itemData['unit_price']),
                        'tax' => floatval($itemData['tax'] ?? 0),
                        'discount' => floatval($itemData['discount'] ?? 0),
                        'total' => $total,
                    ]);
                    $submittedItemIds[] = $item->id;
                }
            } else {
                $newItem = new QuotationItems([
                    'description' => $itemData['description'],
                    'qty' => intval($itemData['qty']),
                    'unit_price' => floatval($itemData['unit_price']),
                    'tax' => floatval($itemData['tax'] ?? 0),
                    'discount' => floatval($itemData['discount'] ?? 0),
                    'total' => $total,
                ]);
                $quotation->items()->save($newItem);
            }
        }

        // Delete removed items
        $itemsToDelete = array_diff($existingItemIds, $submittedItemIds);
        if (!empty($itemsToDelete)) {
            QuotationItems::whereIn('id', $itemsToDelete)->delete();
        }

        // Recalculate quotation totals
        $quotationItems = $quotation->items()->get();
        $subtotal = $quotationItems->sum(function ($item) {
            return $item->qty * $item->unit_price;
        });
        $totalTax = $quotationItems->sum('tax');
        $totalDiscount = $quotationItems->sum('discount');
        $grandTotal = $subtotal + $totalTax - $totalDiscount;

        // Update quotation totals
        $quotation->update([
            'subtotal' => $subtotal,
            'tax' => $totalTax,
            'discount' => $totalDiscount,
            'total' => $grandTotal,
        ]);
    });

    return redirect()->route('quotationlist')->with('success', 'Quotation updated successfully.');
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

    public function view($id)
    {
        $quotation = Quotations::with('client', 'items')->findOrFail($id);
        return view('view', compact('quotation'));
    }

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

    public function edit($id)
    {
        $quotation = Quotations::with('items')->find($id);
        $clients = Clients::all();

        if (!$quotation) {
            return redirect()->route('quotationlist')->with('error', 'Quotation not found.');
        }

        return view('editquotation', compact('quotation', 'clients'));
    }

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

  
    public function download($id)
    {
        $quotation = Quotations::with('items', 'client')->findOrFail($id);

        $company = Company::first(); 

        $pdf = Pdf::loadView('quotations.pdf', compact('quotation', 'company'))
                ->setPaper('a4', 'portrait');

        return $pdf->download('quotation_'.$quotation->id.'.pdf');
    }
    public function sendEmail($id)
    {
        $quotation = Quotations::findOrFail($id);

        if (!$quotation->client || !$quotation->client->email) {
            return back()->with('error', 'Client email not found.');
        }

        Mail::to($quotation->client->email)
            ->send(new QuotationMail($quotation, null, true)); // attach = true

        return back()->with('success', 'Email sent successfully!');
    }


public function generateDescription(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
    ]);

    $title = $request->input('title');
    $apiKey = env('GEMINI_API_KEY');

    if (!$apiKey) {
        return response()->json(['error' => 'GEMINI_API_KEY not set'], 500);
    }

    $apiUrl = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key=' . $apiKey;

    $payload = [
        'contents' => [
            ['parts' => [['text' => "Write a clear and engaging description for a quotation Use only plain words without any bullets commas or symbols Write it in a single paragraph Keep it concise and write accord the discription column size is 255 varchar \"$title\"."]]]
        ],
        'generationConfig' => [
            'temperature' => 0.8,
            'maxOutputTokens' => 2048
        ]
    ];

    try {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post($apiUrl, $payload)->json();

        $generated = $response['candidates'][0]['content']['parts'][0]['text'] ?? null;

        if (!$generated) {
            Log::error('Gemini returned empty response', ['response' => $response]);
            return response()->json(['error' => 'AI did not return a description'], 500);
        }

        return response()->json(['description' => trim($generated)]);
    } catch (\Exception $e) {
        Log::error('Gemini API failed: '.$e->getMessage(), ['trace' => $e->getTraceAsString()]);
        return response()->json(['error' => 'Server error: '.$e->getMessage()], 500);
    }
}



}
