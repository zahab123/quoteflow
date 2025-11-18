<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Quotation - QuoteFlow</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body class="h-screen flex bg-gray-100">

    <!-- Sidebar -->
    <aside class="w-60 bg-white h-full shadow-md border-r flex flex-col justify-between">
        <div class="px-6 py-6 flex items-center gap-2 border-b">
            <div class="w-10 h-10 bg-purple-600 rounded-full flex items-center justify-center text-white font-bold text-lg">QF</div>
            <span class="text-purple-600 font-bold text-xl">QuoteFlow</span>
        </div>

        <ul class="mt-4 flex-1 text-gray-700 font-medium">
            <li>
                <a href="/admin/dashboard"
                   class="flex items-center px-6 py-3 transition rounded-lg
                        {{ request()->is('admin/dashboard') ? 'bg-gradient-to-r from-purple-600 to-pink-500 text-white shadow' : 'hover:bg-gray-100 text-gray-700' }}">
                    Dashboard
                </a>
            </li>
            <li>
                <a href="/clientlist"
                   class="flex items-center px-6 py-3 transition rounded-lg
                        {{ request()->is('clientlist') ? 'bg-gradient-to-r from-purple-600 to-pink-500 text-white shadow' : 'hover:bg-gray-100 text-gray-700' }}">
                    Clients
                </a>
            </li>
            <li>
                <a href="{{ route('quotationlist') }}"
                   class="flex items-center px-6 py-3 transition rounded-lg
                        {{ request()->is('quotationlist') ? 'bg-gradient-to-r from-purple-600 to-pink-500 text-white shadow' : 'hover:bg-gray-100 text-gray-700' }}">
                    Quotations
                </a>
            </li>
        </ul>

        <!-- Profile -->
        <div class="px-6 py-6 flex items-center gap-3 border-t" x-data="{ open: false }">
            <button @click="open = !open"
                    class="w-12 h-12 rounded-full flex items-center justify-center text-white text-lg font-bold"
                    style="background: linear-gradient(135deg, #6366F1, #EC4899);">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </button>
            <div>
                <div class="font-medium text-gray-800">{{ Auth::user()->name }}</div>
                <div class="text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>
            <div x-show="open" @click.away="open = false"
                 class="absolute bottom-20 left-16 w-48 bg-white border rounded shadow-lg z-50">
                <x-dropdown-link :href="route('profile.edit')">Profile</x-dropdown-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">
                        Log Out
                    </x-dropdown-link>
                </form>
            </div>
        </div>
    </aside>

    <!-- Header + Content -->
    <div class="flex-1 flex flex-col">
        <nav class="bg-white border-b border-gray-200">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex justify-end items-center">
                <!-- Header right content -->
            </div>
        </nav>

        <main class="flex-1 p-10 overflow-auto">
            <div class="mb-6 flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Edit Quotation</h1>
                    <p class="text-sm text-gray-500">Update and manage your quotation</p>
                </div>
                <a href="{{ route('quotationlist') }}" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">Back to Quotations</a>
            </div>

            @if(isset($quotation))
            <!-- Status Update Form -->
            <div class="bg-white p-6 rounded-xl shadow mb-6">
                <h2 class="font-semibold text-gray-600 mb-4">Quotation Status</h2>
                <form action="{{ route('quotation.status.update', $quotation->id) }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-2 gap-5 items-end">
                        <div>
                            <label class="text-sm text-gray-600 font-medium">Status *</label>
                            <select name="status" class="w-full border rounded-lg p-2 mt-1" required>
                                <option value="draft" {{ $quotation->status == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="sent" {{ $quotation->status == 'sent' ? 'selected' : '' }}>Sent</option>
                                <option value="viewed" {{ $quotation->status == 'viewed' ? 'selected' : '' }}>Viewed</option>
                                <option value="accepted" {{ $quotation->status == 'accepted' ? 'selected' : '' }}>Accepted</option>
                                <option value="declined" {{ $quotation->status == 'declined' ? 'selected' : '' }}>Declined</option>
                            </select>
                        </div>
                        <div>
                            <label class="text-sm text-gray-600 font-medium">Remarks (Optional)</label>
                            <input type="text" name="remarks" class="w-full border rounded-lg p-2 mt-1" placeholder="Add remarks..." value="">
                        </div>
                        <div>
                            <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded mt-2">Update Status</button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Edit Quotation Form -->
            <form action="{{ route('updatequotation', $quotation->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Basic Information -->
                <div class="bg-white p-6 rounded-xl shadow mb-6">
                    <h2 class="font-semibold text-gray-600 mb-4">Basic Information</h2>
                    <div class="grid grid-cols-2 gap-5">
                        <div>
                            <label class="text-sm text-gray-600 font-medium">Client *</label>
                            <select name="client_id" class="w-full border rounded-lg p-2 mt-1" required>
                                <option value="">Select Client</option>
                                @foreach($clients as $client)
                                    <option value="{{ $client->id }}" {{ $quotation->client_id == $client->id ? 'selected' : '' }}>
                                        {{ $client->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="text-sm text-gray-600 font-medium">Quotation Title *</label>
                            <input type="text" name="title" class="w-full border rounded-lg p-2 mt-1" value="{{ $quotation->title }}" required>
                        </div>
                    </div>
                </div>

                <!-- Line Items -->
                <div class="bg-white p-6 rounded-xl shadow mb-6">
                    <h2 class="font-semibold text-gray-600 mb-4">Line Items</h2>
                    <div id="items-container">
                        @foreach($quotation->items as $index => $item)
                        <div class="grid grid-cols-6 gap-3 mb-2 item-row">
                            <input name="items[{{ $index }}][description]" value="{{ $item->description }}" placeholder="Description" class="border p-2 rounded" required>
                            <input name="items[{{ $index }}][qty]" type="number" value="{{ $item->qty }}" class="border p-2 rounded qty" min="1" required>
                            <input name="items[{{ $index }}][unit_price]" type="number" step="0.01" value="{{ $item->unit_price }}" class="border p-2 rounded unit_price" required>
                            <input name="items[{{ $index }}][tax]" type="number" step="0.01" value="{{ $item->tax }}" class="border p-2 rounded tax" placeholder="Tax">
                            <input name="items[{{ $index }}][discount]" type="number" step="0.01" value="{{ $item->discount }}" class="border p-2 rounded discount" placeholder="Discount">
                            <input type="text" value="$0.00" readonly class="border p-2 rounded bg-gray-100 text-gray-500 total">
                        </div>
                        @endforeach
                    </div>
                    <button type="button" onclick="addItem()" class="mt-2 px-4 py-1 bg-black text-white rounded">+ Add Item</button>
                </div>

                <!-- Summary -->
                <div class="bg-white p-6 rounded-xl shadow mb-6">
                    <h2 class="font-semibold text-gray-600 mb-4">Summary</h2>
                    <div class="text-right space-y-1 text-gray-700">
                        <p>Subtotal: <b id="subtotal">$0.00</b></p>
                        <p>Total Tax: <b id="total-tax">$0.00</b></p>
                        <p>Total Discount: <b id="total-discount">$0.00</b></p>
                        <hr>
                        <p class="text-xl font-bold">Grand Total: <b id="grand-total">$0.00</b></p>
                    </div>
                </div>

                <!-- Notes -->
                <div class="bg-white p-6 rounded-xl shadow mb-6">
                    <label class="text-sm font-medium text-gray-600">Notes (Optional)</label>
                    <textarea name="notes" class="w-full border rounded-lg p-3 mt-2" placeholder="Add any additional notes...">{{ $quotation->notes }}</textarea>
                </div>

                <div class="flex gap-3">
                    <button type="submit" class="px-5 py-2 rounded-lg bg-purple-600 text-white">Update Quotation</button>
                </div>
            </form>

            <!-- Status History -->
            <div class="bg-white p-6 rounded-xl shadow mt-6">
                <h2 class="font-semibold text-gray-600 mb-4">Status History</h2>
                <ul class="border rounded p-4">
                    @foreach($quotation->statusLogs as $log)
                        <li class="mb-2">
                            <strong>{{ ucfirst($log->status) }}</strong> 
                            on {{ \Carbon\Carbon::parse($log->changed_at)->format('d M Y, H:i') }}
                            @if($log->remarks) - {{ $log->remarks }} @endif
                        </li>
                    @endforeach
                </ul>
            </div>

            @else
            <p class="text-red-500">Quotation not found.</p>
            @endif

        </main>
    </div>

<script>
let index = {{ isset($quotation) ? $quotation->items->count() : 0 }};

// Calculate total for one row
function calculateTotal(row) {
    const qty = parseFloat(row.querySelector('.qty').value) || 0;
    const price = parseFloat(row.querySelector('.unit_price').value) || 0;
    const tax = parseFloat(row.querySelector('.tax').value) || 0;
    const discount = parseFloat(row.querySelector('.discount').value) || 0;
    const total = (qty * price) + tax - discount;
    row.querySelector('.total').value = '$' + total.toFixed(2);
    updateSummary();
}

// Update summary totals
function updateSummary() {
    let subtotal = 0, totalTax = 0, totalDiscount = 0;
    document.querySelectorAll('.item-row').forEach(row => {
        const qty = parseFloat(row.querySelector('.qty').value) || 0;
        const price = parseFloat(row.querySelector('.unit_price').value) || 0;
        const tax = parseFloat(row.querySelector('.tax').value) || 0;
        const discount = parseFloat(row.querySelector('.discount').value) || 0;
        subtotal += qty * price;
        totalTax += tax;
        totalDiscount += discount;
    });
    const grandTotal = subtotal + totalTax - totalDiscount;
    document.getElementById('subtotal').innerText = '$' + subtotal.toFixed(2);
    document.getElementById('total-tax').innerText = '$' + totalTax.toFixed(2);
    document.getElementById('total-discount').innerText = '$' + totalDiscount.toFixed(2);
    document.getElementById('grand-total').innerText = '$' + grandTotal.toFixed(2);
}

// Attach input listeners to a row
function attachListenersToRow(row) {
    ['qty', 'unit_price', 'tax', 'discount'].forEach(cls => {
        row.querySelector(`.${cls}`).addEventListener('input', () => calculateTotal(row));
    });
    calculateTotal(row);
}

// Attach listeners to existing rows
document.querySelectorAll('.item-row').forEach(row => attachListenersToRow(row));

// Add new item row
function addItem() {
    const container = document.getElementById('items-container');
    const html = `
    <div class="grid grid-cols-6 gap-3 mb-2 item-row">
        <input name="items[${index}][description]" placeholder="Description" class="border p-2 rounded" required>
        <input name="items[${index}][qty]" type="number" value="1" class="border p-2 rounded qty" min="1" required>
        <input name="items[${index}][unit_price]" type="number" step="0.01" value="0" class="border p-2 rounded unit_price" required>
        <input name="items[${index}][tax]" type="number" step="0.01" value="0" class="border p-2 rounded tax" placeholder="Tax">
        <input name="items[${index}][discount]" type="number" step="0.01" value="0" class="border p-2 rounded discount" placeholder="Discount">
        <input type="text" value="$0.00" readonly class="border p-2 rounded bg-gray-100 text-gray-500 total">
    </div>`;
    container.insertAdjacentHTML('beforeend', html);
    const newRow = container.lastElementChild;
    attachListenersToRow(newRow);
    index++;
}

</script>

</body>
</html>
