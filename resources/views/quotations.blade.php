<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Quotation - QuoteFlow</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
   <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body class="h-full bg-gray-100 flex flex-col">
    <div x-data="{ sidebarOpen: false }" class="h-full flex">
        <!-- Sidebar Overlay -->
        <div x-show="sidebarOpen" @click="sidebarOpen = false"
             class="fixed inset-0 bg-gray-900 bg-opacity-50 z-40 md:hidden"
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
        </div>

        <!-- Sidebar -->
        <aside class="fixed inset-y-0 left-0 z-50 transform w-64 bg-white h-full shadow-2xl border-r border-gray-100 flex flex-col justify-between
                      md:static md:translate-x-0 md:flex-shrink-0"
               :class="{ 'translate-x-0 ease-out': sidebarOpen, '-translate-x-full ease-in': !sidebarOpen }"
               x-transition:enter="transition ease-out duration-300"
               x-transition:leave="transition ease-in duration-300">
            <div class="px-6 py-6 flex items-center gap-2 border-b border-gray-100">
                <button @click="sidebarOpen = false" class="md:hidden mr-3 text-gray-400 hover:text-gray-800 p-1 rounded-full hover:bg-gray-100 transition">
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
                <img src="{{ asset('images/logo.PNG') }}" alt="Logo" class="w-8 h-8 object-contain">
                <span class="text-xl font-extrabold bg-clip-text text-transparent bg-gradient-to-r from-purple-600 via-blue-500 to-pink-500 tracking-wider">
                    QuoteFlow
                </span>
            </div>

            <ul class="mt-4 flex-1 space-y-1 text-gray-700 font-medium">
                <li>
                    <a href="/admin/dashboard"
                       class="flex items-center mx-3 px-3 py-2 transition duration-150 ease-in-out rounded-lg
                              {{ request()->is('admin/dashboard') 
                                  ? 'bg-gradient-to-r from-purple-600 to-pink-500 text-white shadow-md' 
                                  : 'hover:bg-purple-50 hover:text-purple-600 text-gray-700' }}">
                        <x-heroicon-o-home class="w-5 h-5 mr-3" />
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="/clientlist"
                       class="flex items-center mx-3 px-3 py-2 transition duration-150 ease-in-out rounded-lg
                              {{ request()->is('clientlist') 
                                  ? 'bg-gradient-to-r from-purple-600 to-pink-500 text-white shadow-md' 
                                  : 'hover:bg-purple-50 hover:text-purple-600 text-gray-700' }}">
                        <x-heroicon-o-users class="w-5 h-5 mr-3" />
                        Clients
                    </a>
                </li>
                <li>
                    <a href="{{ route('quotationlist') }}"
                       class="flex items-center mx-3 px-3 py-2 transition duration-150 ease-in-out rounded-lg
                              {{ request()->is('quotationlist') 
                                  ? 'bg-gradient-to-r from-purple-600 to-pink-500 text-white shadow-md' 
                                  : 'hover:bg-purple-50 hover:text-purple-600 text-gray-700' }}">
                        <x-heroicon-o-document-text class="w-5 h-5 mr-3" />
                        Quotations
                    </a>
                </li>
                <li>
                    <a href="/report"
                       class="flex items-center mx-3 px-3 py-2 transition duration-150 ease-in-out rounded-lg
                              {{ request()->is('reports') 
                                  ? 'bg-gradient-to-r from-purple-600 to-pink-500 text-white shadow-md' 
                                  : 'hover:bg-purple-50 hover:text-purple-600 text-gray-700' }}">
                        <x-heroicon-o-chart-bar class="w-5 h-5 mr-3" />
                        Reports
                    </a>
                </li>
                <li>
                    <a href="/setting"
                       class="flex items-center mx-3 px-3 py-2 transition duration-150 ease-in-out rounded-lg
                              {{ request()->is('settings') 
                                  ? 'bg-gradient-to-r from-purple-600 to-pink-500 text-white shadow-md' 
                                  : 'hover:bg-purple-50 hover:text-purple-600 text-gray-700' }}">
                        <x-heroicon-o-cog class="w-5 h-5 mr-3" />
                        Settings
                    </a>
                </li>
            </ul>

            <!-- User Profile -->
            <div class="px-6 py-4 flex items-center gap-3 border-t border-gray-100" x-data="{ open: false }">
                <div class="relative w-full flex items-center gap-3">
                    <button @click="open = !open"
                            class="w-12 h-12 rounded-full flex items-center justify-center text-white text-lg font-bold flex-shrink-0"
                            style="background: linear-gradient(135deg, #6366F1, #EC4899);">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </button>
                    <div class="truncate">
                        <div class="font-semibold text-gray-800 truncate">{{ Auth::user()->name }}</div>
                        <div class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</div>
                    </div>
                    <div x-show="open" @click.away="open = false"
                         class="absolute bottom-full mb-3 left-0 w-full bg-white border border-gray-200 rounded-lg shadow-xl z-50 origin-bottom"
                         x-transition:enter="transition ease-out duration-100"
                         x-transition:enter-start="transform opacity-0 scale-95"
                         x-transition:enter-end="transform opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="transform opacity-100 scale-100"
                         x-transition:leave-end="transform opacity-0 scale-95">
                        <x-dropdown-link :href="route('profile.edit')" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-t-lg">Profile</x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-b-lg"
                                             onclick="event.preventDefault(); this.closest('form').submit();">
                                Log Out
                            </x-dropdown-link>
                        </form>
                    </div>
                </div>
            </div>
        </aside>

        <div class="flex-1 flex flex-col overflow-x-hidden overflow-y-auto">
            <nav class="bg-white border-b border-gray-200 shadow-sm sticky top-0 z-30">
                <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16 items-center">
                        <div class="flex items-center space-x-4 w-full sm:w-auto">
                            <button @click="sidebarOpen = true" class="text-gray-500 hover:text-gray-800 md:hidden p-2 rounded-full hover:bg-gray-100 transition">
                                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                </svg>
                            </button>
                            <h1 class="text-xl font-semibold text-gray-800 hidden sm:block">Add Quotation</h1>
                            
                            <div class="relative flex-1 max-w-sm">
                                <input type="text" placeholder="Search..."
                                       class="pl-10 pr-4 py-2 rounded-full border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 outline-none w-full text-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1010.5 3a7.5 7.5 0 006.15 13.65z" />
                                </svg>
                            </div>
                        </div>

                        <div class="flex items-center space-x-3 sm:space-x-4">
                            <button class="relative p-2 rounded-full hover:bg-gray-100 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405C18.21 15.21 18 14.11 18 13V9a6 6 0 10-12 0v4c0 1.11-.21 2.21-.595 3.595L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                                </svg>
                                <span class="absolute top-0 right-0 w-2.5 h-2.5 bg-red-500 rounded-full border-2 border-white"></span>
                            </button>
                            
                            <button id="themeToggle" class="p-2 rounded-full hover:bg-gray-100 transition hidden sm:block">
                                <svg id="sunIcon" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600 dark:hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m8.485-8.485l-.707.707M4.222 4.222l-.707.707M21 12h-1M4 12H3m16.485 4.485l-.707-.707M4.222 19.778l-.707-.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                                <svg id="moonIcon" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-500 hidden dark:block" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M21 12.79A9 9 0 1111.21 3a7 7 0 109.79 9.79z"/>
                                </svg>
                            </button>

                            <div x-data="{ open: false }" class="relative hidden sm:block">
                                <button @click="open = !open"
                                        class="w-10 h-10 rounded-full bg-gradient-to-r from-purple-600 to-pink-500 hover:ring-2 ring-purple-400 flex items-center justify-center text-white text-lg font-bold transition duration-150">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </button>
                                <div x-show="open" @click.away="open = false"
                                     class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-lg shadow-xl z-50 origin-top-right"
                                     x-transition:enter="transition ease-out duration-100"
                                     x-transition:enter-start="transform opacity-0 scale-95"
                                     x-transition:enter-end="transform opacity-100 scale-100"
                                     x-transition:leave="transition ease-in duration-75"
                                     x-transition:leave-start="transform opacity-100 scale-100"
                                     x-transition:leave-end="transform opacity-0 scale-95">
                                    <div class="px-4 py-2 text-sm text-gray-700 border-b border-gray-100">
                                        {{ Auth::user()->email }}
                                    </div>
                                    <x-dropdown-link :href="route('profile.edit')" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                                        Profile
                                    </x-dropdown-link>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <x-dropdown-link :href="route('logout')" class="block px-4 py-2 text-gray-700 hover:bg-gray-100"
                                                         onclick="event.preventDefault(); this.closest('form').submit();">
                                            Log Out
                                        </x-dropdown-link>
                                    </form>
                                </div>
                            </div>
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
                    <a href="{{ route('quotationlist') }}" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">Back to Quotations</a>
                </div>

                <form action="{{ route('addquotation') }}" method="POST">
                    @csrf
                 
                    <div class="bg-white p-6 rounded-xl shadow mb-6">
    <h2 class="font-semibold text-gray-600 mb-4">Basic Information</h2>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
        <!-- Client -->
        <div class="w-full">
            <label class="text-sm text-gray-600 font-medium">Client *</label>
            <select name="client_id" class="w-full border rounded-lg p-2 mt-1" required>
                <option value="">Select Client</option>
                @foreach($clients as $client)
                    <option value="{{ $client->id }}">{{ $client->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Quotation Title -->
        <div class="w-full">
            <label class="text-sm text-gray-600 font-medium">Quotation Title *</label>
            <input type="text" name="title" placeholder="e.g. Website Development Project"
                   class="w-full border rounded-lg p-2 mt-1" required>
        </div>

        <!-- Quotation Date -->
        <div class="w-full">
            <label class="text-sm text-gray-600 font-medium">Quotation Date *</label>
            <input type="date" name="quotation_date" value="{{ date('Y-m-d') }}"
                   class="w-full border rounded-lg p-2 mt-1" required>
        </div>
    </div>
</div>


                  <div class="bg-white p-6 rounded-xl shadow mb-6">
    <h2 class="font-semibold text-gray-600 mb-4">Line Items</h2>

    <div id="items-container">
        <p class="error-msg text-red-600 text-sm mt-1 hidden"></p>

        <div class="mb-4 item-row">
            
           <div class="flex flex-col relative mb-4 p-4 border border-gray-300 rounded-lg shadow-md transition duration-300 hover:shadow-lg">
    <label class="text-sm font-semibold text-gray-700 mb-1">Description</label>
    <div class="relative">
        <input 
            name="items[0][description]"
            placeholder="Enter item description..."
            class="w-full border-2 border-gray-300 p-3 pr-16 rounded-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 description"
            required
            id="item-0-description" >
        <button 
            type="button"
            onclick="generateDescription(this, 'item-0-description')" class="absolute top-1/2 right-2 transform -translate-y-1/2 px-3 py-1 bg-indigo-600 text-white font-medium rounded-md text-sm hover:bg-indigo-700"
            id="item-0-ai-button" >
            AI
        </button>
    </div>
</div>
            <!-- Item Inputs Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-3">

                <div class="flex flex-col">
                    <label class="text-xs text-gray-500">Quantity</label>
                    <input name="items[0][qty]" type="number" value="1"
                           class="border p-2 rounded qty" min="1" required>
                </div>

                <div class="flex flex-col">
                    <label class="text-xs text-gray-500">Unit Price</label>
                    <input name="items[0][unit_price]" type="number" step="0.01"
                           value="0" class="border p-2 rounded unit_price" required>
                </div>

                <div class="flex flex-col">
                    <label class="text-xs text-gray-500">Tax</label>
                    <input name="items[0][tax]" type="number" step="0.01"
                           value="0" class="border p-2 rounded tax">
                </div>

                <div class="flex flex-col">
                    <label class="text-xs text-gray-500">Discount</label>
                    <input name="items[0][discount]" type="number" step="0.01"
                           value="0" class="border p-2 rounded discount">
                </div>

                <div class="flex flex-col">
                    <label class="text-xs text-gray-500">Total</label>
                    <input type="text" value="RS0.00" readonly
                           class="border p-2 rounded bg-gray-100 text-gray-500 total">
                </div>

                <div class="flex flex-col">
                    <label class="text-xs text-gray-500">Remove</label>
                    <button type="button" onclick="removeItem(this)"
                            class="p-2 bg-red-500 text-white rounded hover:bg-red-600 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" stroke="currentColor">
                            <polyline points="3 6 5 6 21 6"></polyline>
                            <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"></path>
                            <path d="M10 11v6"></path>
                            <path d="M14 11v6"></path>
                        </svg>
                    </button>
                </div>

            </div>
        </div>
    </div>

    <button type="button" onclick="addItem()"
            class="mt-2 px-4 py-1 bg-black text-white rounded hover:bg-gray-800">
        + Add Item
    </button>
</div>


                    <div class="bg-white p-6 rounded-xl shadow mb-6">
                        <h2 class="font-semibold text-gray-600 mb-4">Summary</h2>
                        <div class="text-right space-y-1 text-gray-700">
                            <p>Subtotal: <b id="subtotal">RS0.00</b></p>
                            <p>Total Tax: <b id="total-tax">RS0.00</b></p>
                            <p>Total Discount: <b id="total-discount">RS0.00</b></p>
                            <hr>
                            <p class="text-xl font-bold">Grand Total: <b id="grand-total">RS0.00</b></p>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-xl shadow mb-6">
                        <label class="text-sm font-medium text-gray-600">Notes (Optional)</label>
                        <textarea id="notes_field" name="notes" class="w-full border rounded-lg p-3 mt-2" placeholder="Add any additional notes..."></textarea>
                    </div>

                    <div class="flex gap-3">

                       <button type="submit" id="saveDraftBtn" name="status" value="draft"
        class="px-5 py-2 rounded-lg bg-gray-500 text-white hover:bg-gray-600 transition">
    Save as Draft
</button>

                    </div>
                </form>
            </main>
        </div>
    </div>

    <script>
        let index = 1;

        function calculateTotal(row) {
            const qty = parseFloat(row.querySelector('.qty').value) || 0;
            const price = parseFloat(row.querySelector('.unit_price').value) || 0;
            const tax = parseFloat(row.querySelector('.tax').value) || 0;
            const discount = parseFloat(row.querySelector('.discount').value) || 0;
            const total = (qty * price) + tax - discount;
            row.querySelector('.total').value = 'RS' + total.toFixed(2);
            updateSummary();
        }

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
            document.getElementById('subtotal').innerText = 'RS' + subtotal.toFixed(2);
            document.getElementById('total-tax').innerText = 'RS' + totalTax.toFixed(2);
            document.getElementById('total-discount').innerText = 'RS' + totalDiscount.toFixed(2);
            document.getElementById('grand-total').innerText = 'RS' + grandTotal.toFixed(2);
        }

        document.getElementById("saveDraftBtn").addEventListener("click", function (e) {
    const items = document.querySelectorAll(".item-row");
    const errorBox = document.querySelector(".error-msg");

    if (items.length < 1) {
        e.preventDefault();
        errorBox.textContent = "At least one line item is required before saving.";
        errorBox.classList.remove("hidden");
        return false;
    }

    // Hide previous error
    errorBox.classList.add("hidden");

    // If only 1 item, set unit price to 1 if it's empty or 0
    if (items.length === 1) {
        const unitPriceInput = items[0].querySelector(".unit_price");
        if (!unitPriceInput.value || parseFloat(unitPriceInput.value) <= 0) {
            unitPriceInput.value = 100;
        }
    }
});


        function attachListenersToRow(row) {
            ['qty', 'unit_price', 'tax', 'discount'].forEach(cls => {
                row.querySelector(`.${cls}`).addEventListener('input', () => calculateTotal(row));
            });
            const deleteBtn = row.querySelector('.delete-btn');
            if(deleteBtn){
                deleteBtn.addEventListener('click', () => {
                    row.remove();
                    updateSummary();
                });
            }
            calculateTotal(row);
        }

        function attachListeners() {
            document.querySelectorAll('.item-row').forEach(row => attachListenersToRow(row));
        }

function addItem() {
    const container = document.getElementById('items-container');

    const html = `
    <div class="mb-4 item-row">

        <!-- Description Input -->
        <div class="flex flex-col relative mb-4 p-4 border border-gray-300 rounded-lg shadow-md transition duration-300 hover:shadow-lg">
            <label class="text-sm font-semibold text-gray-700 mb-1">Description</label>
            <div class="relative">
                <input 
                    name="items[${index}][description]"
                    id="item-description-${index}"
                    placeholder="Enter item description..."
                    class="w-full border-2 border-gray-300 p-3 pr-16 rounded-lg text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 description"
                    required
                >
                <button 
                    type="button"
                    onclick="generateDescription(this)"
                    class="absolute top-1/2 right-2 transform -translate-y-1/2 px-3 py-1 bg-indigo-600 text-white font-medium rounded-md text-sm hover:bg-indigo-700"
                >
                    AI
                </button>
            </div>
        </div>

        <!-- Responsive Fields Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-3">

            <div class="flex flex-col">
                <label class="text-xs text-gray-500">Quantity</label>
                <input name="items[${index}][qty]" type="number" value="1"
                       class="border p-2 rounded qty" min="1" required>
            </div>

            <div class="flex flex-col">
                <label class="text-xs text-gray-500">Unit Price</label>
                <input name="items[${index}][unit_price]" type="number" step="0.01"
                       value="0" class="border p-2 rounded unit_price" required>
            </div>

            <div class="flex flex-col">
                <label class="text-xs text-gray-500">Tax</label>
                <input name="items[${index}][tax]" type="number" step="0.01"
                       value="0" class="border p-2 rounded tax">
            </div>

            <div class="flex flex-col">
                <label class="text-xs text-gray-500">Discount</label>
                <input name="items[${index}][discount]" type="number" step="0.01"
                       value="0" class="border p-2 rounded discount">
            </div>

            <div class="flex flex-col">
                <label class="text-xs text-gray-500">Total</label>
                <input type="text" value="RS0.00" readonly
                       class="border p-2 rounded bg-gray-100 text-gray-500 total">
            </div>

            <div class="flex flex-col">
                <label class="text-xs text-gray-500">Remove</label>
                <button type="button" onclick="removeItem(this)"
                        class="p-2 bg-red-500 text-white rounded hover:bg-red-600 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" stroke="currentColor">
                        <polyline points="3 6 5 6 21 6"></polyline>
                        <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"></path>
                        <path d="M10 11v6"></path>
                        <path d="M14 11v6"></path>
                    </svg>
                </button>
            </div>

        </div>
    </div>
    `;

    container.insertAdjacentHTML('beforeend', html);
    attachListenersToRow(container.lastElementChild);
    index++;
}

function removeItem(button) {
    const itemRow = button.closest('.item-row'); 
    if (itemRow) {
        itemRow.remove(); 
    }
}

        attachListeners();
 // Put this in your <script> area (replace existing generateDescription)
const MAX_DESCRIPTION_LENGTH = 255; // sync with backend limit

function showRowError(row, message) {
    const err = row.querySelector('.error-msg');
    const desc = row.querySelector('.description');
    if (err) {
        err.innerText = message;
        err.classList.remove('hidden');
    }
    if (desc) {
        desc.classList.add('border-red-500', 'ring-1', 'ring-red-400');
    }
}

function clearRowError(row) {
    const err = row.querySelector('.error-msg');
    const desc = row.querySelector('.description');
    if (err) {
        err.innerText = '';
        err.classList.add('hidden');
    }
    if (desc) {
        desc.classList.remove('border-red-500', 'ring-1', 'ring-red-400');
    }
}

function showGlobalToast(message) {
    const toast = document.getElementById('global-toast');
    const msg = document.getElementById('global-toast-msg');
    if (!toast || !msg) return;
    msg.innerText = message;
    toast.classList.remove('hidden');
    // auto-hide after 6s
    clearTimeout(showGlobalToast._timeout);
    showGlobalToast._timeout = setTimeout(() => {
        hideGlobalToast();
    }, 6000);
}

function hideGlobalToast() {
    const toast = document.getElementById('global-toast');
    if (!toast) return;
    toast.classList.add('hidden');
}

// Updated generateDescription (async)
async function generateDescription(button) {
    const row = button.closest('.item-row');
    const titleInput = document.querySelector('input[name="title"]');
    const descriptionInput = row.querySelector('.description');

    // Store original state to restore later
    const originalButtonText = button.textContent;
    const originalPlaceholder = descriptionInput.placeholder;
    
    // Function to reset the state in case of success or error
    const resetState = () => {
        button.textContent = originalButtonText;
        button.disabled = false;
        descriptionInput.placeholder = originalPlaceholder;
        descriptionInput.disabled = false;
    };

    clearRowError(row);

    if (!titleInput.value) {
        showRowError(row, "Please enter a quotation title first.");
        return;
    }

    // --- START: Set Loading State ---
    try {
        button.textContent = '...'; // Change button text to an indicator
        button.disabled = true; // Disable the button
        descriptionInput.value = ''; // Clear previous value
        descriptionInput.placeholder = 'AI content is generating...'; // Set loading message
        descriptionInput.disabled = true; // Disable the input
        
        const response = await fetch("{{ route('quotations.generateDescription') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ title: titleInput.value })
        });

        let data;
        try {
            data = await response.json();
        } catch (jsonErr) {
            showGlobalToast("Unexpected server response (not JSON).");
            console.error('Invalid JSON response', jsonErr);
            resetState(); // Reset state on JSON error
            return;
        }

        if (!response.ok) {
            const serverMsg = data.error || 'AI service error';
            if (data.error && data.error.toLowerCase().includes('long')) {
                showRowError(row, serverMsg);
            } else {
                showGlobalToast(serverMsg);
            }
            resetState(); // Reset state on server error
            return;
        }

        if (!data.description) {
            const errMsg = data.error || 'AI did not return a description.';
            showGlobalToast(errMsg);
            resetState(); // Reset state on no description
            return;
        }

        if (data.description.length > MAX_DESCRIPTION_LENGTH) {
            showRowError(row, `Description is too long. Maximum ${MAX_DESCRIPTION_LENGTH} characters allowed.`);
            resetState(); // Reset state on length error
            return;
        }

        // --- SUCCESS: Apply result and Reset State ---
        descriptionInput.value = data.description;
        clearRowError(row);
        resetState(); // Reset state on success

    } catch (err) {
        console.error('generateDescription failed:', err);
        showGlobalToast('An error occurred while calling the AI. Please try again.');
        resetState(); // Reset state on network/unexpected error
    }
}

    </script>
</body>
</html>
