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
        $clients = Clients::where('user_id', Auth::id())->get(); // Only current user's clients
        return view('quotations', compact('clients'));
    }

    // Add new quotation
    public function addquotation(Request $request)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'title' => 'required|string|max:255',
            'items' => 'required|array|min:1',
            'items.*.description' => 'nullable|string|max:500',
            'items.*.qty' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
            'items.*.tax' => 'nullable|numeric|min:0',
            'items.*.discount' => 'nullable|numeric|min:0',
            'status' => 'required|in:sent,draft'
        ], [
            'items.*.description.max' => 'Description cannot exceed 500 characters.',
            'status.in' => 'Selected status is invalid.'
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
                'description' => $item['description'] ?? null,
                'qty' => $item['qty'],
                'unit_price' => $item['unit_price'],
                'tax' => $item['tax'] ?? 0,
                'discount' => $item['discount'] ?? 0,
                'total' => $itemTotal
            ]);
        }

        QuotationStatusLog::create([
            'quotation_id' => $quotation->id,
            'status' => (string) $request->status, 
            'changed_at' => now(),
            'remarks' => null
        ]);

        return redirect()->route('quotationlist')->with('success', 'Quotation added successfully!');
    }

    // Update quotation
    public function update(Request $request, $id)
    {
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
            $quotation = Quotations::with('items')
                ->where('user_id', Auth::id())
                ->findOrFail($id);

            $quotation->client_id = $request->client_id;
            $quotation->title = $request->title;
            $quotation->save();

            $existingItemIds = $quotation->items->pluck('id')->toArray();
            $submittedItemIds = [];

            foreach ($request->items as $itemData) {
                $total = ($itemData['qty'] * $itemData['unit_price']) + floatval($itemData['tax'] ?? 0) - floatval($itemData['discount'] ?? 0);

                if (isset($itemData['id'])) {
                    $item = QuotationItems::find($itemData['id']);
                    if ($item && $item->quotation_id == $quotation->id) {
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

            $itemsToDelete = array_diff($existingItemIds, $submittedItemIds);
            if (!empty($itemsToDelete)) {
                QuotationItems::whereIn('id', $itemsToDelete)->delete();
            }

            $quotationItems = $quotation->items()->get();
            $subtotal = $quotationItems->sum(fn($item) => $item->qty * $item->unit_price);
            $totalTax = $quotationItems->sum('tax');
            $totalDiscount = $quotationItems->sum('discount');
            $grandTotal = $subtotal + $totalTax - $totalDiscount;

            $quotation->update([
                'subtotal' => $subtotal,
                'tax' => $totalTax,
                'discount' => $totalDiscount,
                'total' => $grandTotal,
            ]);
        });

        return redirect()->route('quotationlist')->with('success', 'Quotation updated successfully.');
    }

    // List all quotations
    public function quotationlist(Request $request)
    {
        $query = Quotations::with('items', 'client')
            ->where('user_id', Auth::id()); // Filter by current user

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%$search%")
                  ->orWhereHas('client', fn($q2) => $q2->where('name', 'like', "%$search%"));
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $quotations = $query->orderBy('created_at', 'desc')->paginate(12);
        return view('quotationlist', compact('quotations'));
    }

    // View quotation
    public function view($id)
    {
        $quotation = Quotations::with('client', 'items')
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('view', compact('quotation'));
    }

    // Delete quotation
    public function delete($id)
    {
        $quotation = Quotations::where('user_id', Auth::id())
            ->findOrFail($id);

        $quotation->items()->delete();
        $quotation->delete();

        return redirect()->back()->with('success', 'Quotation deleted successfully.');
    }

    // Edit quotation
    public function edit($id)
    {
        $quotation = Quotations::with('items')
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        $clients = Clients::where('user_id', Auth::id())->get(); // Only current user's clients

        return view('editquotation', compact('quotation', 'clients'));
    }

    // Copy quotation
    public function copy($id)
    {
        $original = Quotations::with('items')
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        $copy = $original->replicate();
        $copy->user_id = Auth::id(); // Assign current user
        $copy->status = 'Draft';
        $copy->save();

        foreach ($original->items as $item) {
            $copy->items()->create($item->toArray());
        }

        return redirect()->route('quotationlist')->with('success', 'Quotation copied successfully!');
    }

    // Download PDF
    public function download($id)
    {
        $quotation = Quotations::with('items', 'client')
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        $company = Company::where('user_id', Auth::id())->first(); // User's company

        $pdf = Pdf::loadView('quotations.pdf', compact('quotation', 'company'))
            ->setPaper('a4', 'portrait');

        return $pdf->download('quotation_'.$quotation->id.'.pdf');
    }

    // Send quotation email
   public function sendEmail($id)
{
    $quotation = Quotations::where('user_id', Auth::id())
        ->findOrFail($id);

    if (!$quotation->client || !$quotation->client->email) {
        return back()->with('error', 'Client email not found.');
    }

   
    Mail::to($quotation->client->email)
        ->send(new QuotationMail($quotation, null, true));


    $quotation->status = 'sent';
    $quotation->save();

    
    QuotationStatusLog::create([
        'quotation_id' => $quotation->id,
        'status' => 'sent',
        'changed_at' => now(),
        'remarks' => 'Quotation PDF sent to client'
    ]);

    return back()->with('success', 'Email sent Sucessfully');
}


    // Generate AI description
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
            ['parts' => [['text' => 
                "Write a clear and engaging description for a quotation. 
                 Use only plain words without any bullets, commas, or symbols. 
                 Write it in a single paragraph. 
                 Keep it concise and write according to the description column size (255 varchar). 
                 Title: \"$title\"."
            ]]]
        ],
        'generationConfig' => [
            'temperature' => 0.8,
            'maxOutputTokens' => 2048
        ]
    ];

    try {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post($apiUrl, $payload);

        if ($response->failed()) {
            return response()->json(['error' => 'AI request failed'], 500);
        }

        $data = $response->json();
        $generated = $data['candidates'][0]['content']['parts'][0]['text'] ?? null;

        // If AI gives no output
        if (!$generated) {
            Log::error('Gemini returned empty response', ['response' => $data]);
            return response()->json(['error' => 'AI did not return a description'], 500);
        }

        $generated = trim($generated);

        // ✅ NEW CHECK — Limit to 255 characters
        if (strlen($generated) > 255) {
            return response()->json([
                'error' => 'AI description is too long. Maximum allowed is 255 characters.'
            ], 422);
        }

        return response()->json(['description' => $generated]);

    } catch (\Exception $e) {
        Log::error('Gemini API failed: ' . $e->getMessage(), [
            'trace' => $e->getTraceAsString()
        ]);

        return response()->json([
            'error' => 'Server error: ' . $e->getMessage()
        ], 500);
    }
}

}
