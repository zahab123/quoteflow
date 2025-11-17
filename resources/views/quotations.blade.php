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

<!-- SIDEBAR -->
<aside class="w-60 bg-white h-full shadow-md border-r flex flex-col justify-between">
    <div class="px-6 py-6 flex items-center gap-2 border-b">
        <div class="w-10 h-10 bg-purple-600 rounded-full flex items-center justify-center text-white font-bold text-lg">QF</div>
        <span class="text-purple-600 font-bold text-xl">QuoteFlow</span>
    </div>
    <ul class="mt-4 space-y-1 text-gray-700 font-medium flex-1">
        <li><a href="/admin/dashboard" class="block px-6 py-2 hover:bg-gray-100 rounded">Dashboard</a></li>
        <li><a href="/clientlist" class="block px-6 py-2 hover:bg-gray-100 rounded">Clients</a></li>
        <li><a href="/quotationlist" class="block px-6 py-2 hover:bg-gray-100 rounded bg-gray-200 font-semibold">Quotations</a></li>
        <li><a href="/reports" class="block px-6 py-2 hover:bg-gray-100 rounded">Reports</a></li>
        <li><a href="/settings" class="block px-6 py-2 hover:bg-gray-100 rounded">Settings</a></li>
    </ul>
</aside>

<!-- MAIN CONTENT -->
<div class="flex-1 flex flex-col h-full overflow-hidden">
    <nav class="bg-white border-b border-gray-100 flex-shrink-0">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center space-x-4">
                    <button onclick="document.documentElement.classList.toggle('dark')" class="p-2 rounded-full hover:bg-gray-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 3v1m0 16v1m8.485-8.485l-.707.707M4.222 4.222l-.707.707M21 12h-1M4 12H3m16.485 4.485l-.707-.707M4.222 19.778l-.707-.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </nav>
    <main class="flex-1 p-10 overflow-auto">

        <div class="mb-6 flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">New Quotation</h1>
                <p class="text-sm text-gray-500">Create and manage your quotations</p>
            </div>
            <a href="/quotationlist" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">Back to Quotations</a>
        </div>
        <form action="{{ route('addquotation') }}" method="POST">
            @csrf
            <div class="bg-white p-6 rounded-xl shadow mb-6">
                <h2 class="font-semibold text-gray-600 mb-4">Basic Information</h2>
                <div class="grid grid-cols-2 gap-5">
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
                </div>
            </div>
<div class="bg-white p-6 rounded-xl shadow mb-6">
    <h2 class="font-semibold text-gray-600 mb-4">Line Items</h2>
    <div id="items-container">

        <div class="grid grid-cols-6 gap-3 mb-2 item-row">

            <div class="flex flex-col">
                <label class="text-sm text-gray-600 mb-1">Description</label>
                <input name="items[0][description]" placeholder="Item description" class="border p-2 rounded" required>
            </div>
            <div class="flex flex-col">
                <label class="text-sm text-gray-600 mb-1">Quantity</label>
                <input name="items[0][qty]" placeholder="Qty" type="number" value="1" class="border p-2 rounded qty" min="1" required>
            </div>
            <div class="flex flex-col">
                <label class="text-sm text-gray-600 mb-1">Unit Price</label>
                <input name="items[0][unit_price]" placeholder="Unit Price" type="number" step="0.01" value="0" class="border p-2 rounded unit_price" required>
            </div>
            <div class="flex flex-col">
                <label class="text-sm text-gray-600 mb-1">Tax (%)</label>
                <input name="items[0][tax]" type="number" step="0.01" placeholder="Tax" value="0" class="border p-2 rounded tax">
            </div>
            <div class="flex flex-col">
                <label class="text-sm text-gray-600 mb-1">Discount (%)</label>
                <input name="items[0][discount]" type="number" step="0.01" value="0" placeholder="Discount" class="border p-2 rounded discount">
            </div>
            <div class="flex flex-col">
                <label class="text-sm text-gray-600 mb-1">Total</label>
                <input type="text" value="$0.00" readonly class="border p-2 rounded bg-gray-100 text-gray-500 total">
            </div>

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
                <button type="submit" class="px-5 py-2 rounded-lg bg-purple-600 text-white">Save & Send</button>
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

    let baseTotal = qty * price;
    let taxAmount = baseTotal * (tax / 100);
    let discountAmount = baseTotal * (discount / 100);
    let total = baseTotal + taxAmount - discountAmount;

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

        let rowSubtotal = qty * price;
        subtotal += rowSubtotal;
        totalTax += rowSubtotal * (tax / 100);
        totalDiscount += rowSubtotal * (discount / 100);
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
        <input name="items[${index}][unit_price]" placeholder="Price" type="number" step="0.01" value="0" class="border p-2 rounded unit_price" required>
        <input name="items[${index}][tax]" placeholder="Tax" type="number" step="0.01" value="0" class="border p-2 rounded tax">
        <input name="items[${index}][discount]" placeholder="Discount" type="number" step="0.01" value="0" class="border p-2 rounded discount">
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
