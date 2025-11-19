<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Quotation - QuoteFlow</title>
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
                <a href="/admin/dashboard" class="flex items-center px-6 py-3 transition rounded-lg
                    {{ request()->is('admin/dashboard') ? 'bg-gradient-to-r from-purple-600 to-pink-500 text-white shadow' : 'hover:bg-gray-100 text-gray-700' }}">
                    <x-heroicon-o-home class="w-5 h-5 mr-3" /> Dashboard
                </a>
            </li>
            <li>
                <a href="/clientlist" class="flex items-center px-6 py-3 transition rounded-lg
                    {{ request()->is('clientlist') ? 'bg-gradient-to-r from-purple-600 to-pink-500 text-white shadow' : 'hover:bg-gray-100 text-gray-700' }}">
                    <x-heroicon-o-users class="w-5 h-5 mr-3" /> Clients
                </a>
            </li>
            <li>
                <a href="{{ route('quotationlist') }}" class="flex items-center px-6 py-3 transition rounded-lg
                    {{ request()->is('quotationlist') ? 'bg-gradient-to-r from-purple-600 to-pink-500 text-white shadow' : 'hover:bg-gray-100 text-gray-700' }}">
                    <x-heroicon-o-document-text class="w-5 h-5 mr-3" /> Quotations
                </a>
            </li>
            <li>
                <a href="/report" class="flex items-center px-6 py-3 transition rounded-lg
                    {{ request()->is('reports') ? 'bg-gradient-to-r from-purple-600 to-pink-500 text-white shadow' : 'hover:bg-gray-100 text-gray-700' }}">
                    <x-heroicon-o-chart-bar class="w-5 h-5 mr-3" /> Reports
                </a>
            </li>
            <li>
                <a href="/setting" class="flex items-center px-6 py-3 transition rounded-lg
                    {{ request()->is('settings') ? 'bg-gradient-to-r from-purple-600 to-pink-500 text-white shadow' : 'hover:bg-gray-100 text-gray-700' }}">
                    <x-heroicon-o-cog class="w-5 h-5 mr-3" /> Settings
                </a>
            </li>
        </ul>

        <div class="px-6 py-6 flex items-center gap-3 border-t" x-data="{ open: false }">
            <button @click="open = !open" class="w-12 h-12 rounded-full flex items-center justify-center text-white text-lg font-bold" style="background: linear-gradient(135deg, #6366F1, #EC4899);">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </button>
            <div>
                <div class="font-medium text-gray-800">{{ Auth::user()->name }}</div>
                <div class="text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>
            <div x-show="open" @click.away="open = false" class="absolute bottom-20 left-16 w-48 bg-white border rounded shadow-lg z-50">
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
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-end h-16 items-center space-x-6">
                    <button class="relative p-2 rounded-full hover:bg-gray-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405C18.21 15.21 18 14.11 18 13V9a6 6 0 10-12 0v4c0 1.11-.21 2.21-.595 3.595L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                        <span class="absolute top-0 right-0 w-2 h-2 bg-red-500 rounded-full"></span>
                    </button>
                </div>
            </div>
        </nav>
    <main class="flex-1 p-10 overflow-auto">

        <div class="mb-6 flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">New Quotation</h1>
                <p class="text-sm text-gray-500">Create and manage your quotations</p>
            </div>
            <a href="{{ route('quotationlist') }}" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">Back to Quotations</a>
        </div>

        <form action="{{ route('addquotation') }}" method="POST">
            @csrf
            <div class="bg-white p-6 rounded-xl shadow mb-6">
                <h2 class="font-semibold text-gray-600 mb-4">Basic Information</h2>
                <div class="grid grid-cols-3 gap-5">
                    <div>
                        <label class="text-sm text-gray-600 font-medium">Client *</label>
                        <select name="client_id" class="w-full border rounded-lg p-2 mt-1" required>
                            <option value="">Select Client</option>
                            @foreach($clients as $client)
                                <option value="{{ $client->id }}">{{ $client->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="text-sm text-gray-600 font-medium">Quotation Title *</label>
                        <input type="text" name="title" placeholder="e.g. Website Development Project" class="w-full border rounded-lg p-2 mt-1" required>
                    </div>

                    <div>
                        <label class="text-sm text-gray-600 font-medium">Quotation Date *</label>
                        <input type="date" name="quotation_date" value="{{ date('Y-m-d') }}" class="w-full border rounded-lg p-2 mt-1" required>
                    </div>

                    <div>
                        <label class="text-sm text-gray-600 font-medium">Valid Until *</label>
                        <input type="date" name="valid_until" value="{{ date('Y-m-d', strtotime('+30 days')) }}" class="w-full border rounded-lg p-2 mt-1" required>
                    </div>
                </div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow mb-6">
                <h2 class="font-semibold text-gray-600 mb-4">Line Items</h2>
                <div id="items-container">
                    <div class="grid grid-cols-6 gap-3 mb-2 item-row">
                        <input name="items[0][description]" placeholder="Description" class="border p-2 rounded" required>
                        <input name="items[0][qty]" placeholder="Quantity" type="number" value="1" class="border p-2 rounded qty" min="1" required>
                        <input name="items[0][unit_price]" placeholder="Unit Price" type="number" step="0.01" value="0" class="border p-2 rounded unit_price" required>
                        <input name="items[0][tax]" type="number" step="0.01" value="0" class="border p-2 rounded tax" placeholder="Tax">
                        <input name="items[0][discount]" type="number" step="0.01" value="0" class="border p-2 rounded discount" placeholder="Discount">
                        <input type="text" value="$0.00" readonly class="border p-2 rounded bg-gray-100 text-gray-500 total">
                    </div>
                </div>
                <button type="button" onclick="addItem()" class="mt-2 px-4 py-1 bg-black text-white rounded">+ Add Item</button>
            </div>

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

            <div class="bg-white p-6 rounded-xl shadow mb-6">
                <label class="text-sm font-medium text-gray-600">Notes (Optional)</label>
                <textarea name="notes" class="w-full border rounded-lg p-3 mt-2" placeholder="Add any additional notes..."></textarea>
            </div>

            <div class="flex gap-3">
                <!-- Save & Send -->
                <button type="submit" name="status" value="sent" 
                        class="px-5 py-2 rounded-lg bg-purple-600 text-white hover:bg-purple-700 transition">
                    Save & Send
                </button>

                <!-- Save as Draft -->
                <button type="submit" name="status" value="draft" 
                        class="px-5 py-2 rounded-lg bg-gray-500 text-white hover:bg-gray-600 transition">
                    Save as Draft
                </button>
            </div>
        </form>

    </main>
</div>

<script>
let index = 1;

function calculateTotal(row) {
    const qty = parseFloat(row.querySelector('.qty').value) || 0;
    const price = parseFloat(row.querySelector('.unit_price').value) || 0;
    const tax = parseFloat(row.querySelector('.tax').value) || 0;
    const discount = parseFloat(row.querySelector('.discount').value) || 0;

    const total = (qty * price) + tax - discount;
    row.querySelector('.total').value = '$' + total.toFixed(2);
    updateSummary();
}

function updateSummary() {
    let subtotal = 0;
    let totalTax = 0;
    let totalDiscount = 0;

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

function attachListeners() {
    document.querySelectorAll('.item-row').forEach(row => {
        ['qty', 'unit_price', 'tax', 'discount'].forEach(cls => {
            row.querySelector(`.${cls}`).addEventListener('input', () => calculateTotal(row));
        });
        calculateTotal(row);
    });
}

function addItem() {
    const container = document.getElementById('items-container');
    const html = `
    <div class="grid grid-cols-6 gap-3 mb-2 item-row">
        <input name="items[${index}][description]" placeholder="Description" class="border p-2 rounded" required>
        <input name="items[${index}][qty]" placeholder="Quantity" type="number" value="1" class="border p-2 rounded qty" min="1" required>
        <input name="items[${index}][unit_price]" placeholder="Unit Price" type="number" step="0.01" value="0" class="border p-2 rounded unit_price" required>
        <input name="items[${index}][tax]" type="number" step="0.01" value="0" class="border p-2 rounded tax" placeholder="Tax">
        <input name="items[${index}][discount]" type="number" step="0.01" value="0" class="border p-2 rounded discount" placeholder="Discount">
        <input type="text" value="$0.00" readonly class="border p-2 rounded bg-gray-100 text-gray-500 total">
    </div>`;
    container.insertAdjacentHTML('beforeend', html);
    index++;
    attachListeners();
}

attachListeners();
</script>

</body>
</html>
