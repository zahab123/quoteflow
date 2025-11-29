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

        <!-- Main Content -->
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
                        <h1 class="text-xl font-semibold text-gray-800 hidden sm:block">Dashboard</h1>
                    </div>
                </div>
            </div>
        </nav>

        <main class="flex-1 p-6 sm:p-10 overflow-auto">
            <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">New Quotation</h1>
                    <p class="text-sm text-gray-500">Create and manage your quotations</p>
                </div>
                <a href="{{ route('quotationlist') }}" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">Back to Quotations</a>
            </div>

            <form action="{{ route('addquotation') }}" method="POST">
                @csrf
                <!-- Basic Information -->
                <div class="bg-white p-6 rounded-xl shadow mb-6">
                    <h2 class="font-semibold text-gray-600 mb-4">Basic Information</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
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
                    </div>
                </div>

                <!-- Line Items -->
                <div class="bg-white p-6 rounded-xl shadow mb-6">
                    <h2 class="font-semibold text-gray-600 mb-4">Line Items</h2>
                    <div id="items-container">
                        <div class="grid grid-cols-7 gap-3 mb-2 item-row items-end">
                            <div class="flex flex-col relative">
                                <label class="text-xs text-gray-500">Description</label>
                                <input name="items[0][description]" placeholder="Description" class="border p-2 rounded description" required>
                                <button type="button" onclick="generateDescription(this)" class="absolute top-0 right-0 mt-1 mr-1 px-2 py-1 bg-blue-500 text-white rounded text-xs hover:bg-blue-600">AI</button>
                            </div>
                            <div class="flex flex-col">
                                <label class="text-xs text-gray-500">Quantity</label>
                                <input name="items[0][qty]" type="number" value="1" class="border p-2 rounded qty" min="1" required>
                            </div>
                            <div class="flex flex-col">
                                <label class="text-xs text-gray-500">Unit Price</label>
                                <input name="items[0][unit_price]" type="number" step="0.01" value="0" class="border p-2 rounded unit_price" required>
                            </div>
                            <div class="flex flex-col">
                                <label class="text-xs text-gray-500">Tax</label>
                                <input name="items[0][tax]" type="number" step="0.01" value="0" class="border p-2 rounded tax">
                            </div>
                            <div class="flex flex-col">
                                <label class="text-xs text-gray-500">Discount</label>
                                <input name="items[0][discount]" type="number" step="0.01" value="0" class="border p-2 rounded discount">
                            </div>
                            <div class="flex flex-col">
                                <label class="text-xs text-gray-500">Total</label>
                                <input type="text" value="RS0.00" readonly class="border p-2 rounded bg-gray-100 text-gray-500 total">
                            </div>
                            <div class="flex flex-col">
                                <label class="text-xs text-gray-500">Remove</label>
                                <button type="button" onclick="removeItem(this)" class="p-2 bg-red-500 text-white rounded hover:bg-red-600 flex items-center justify-center">
                                    ✕
                                </button>
                            </div>
                        </div>
                    </div>
                    <button type="button" onclick="addItem()" class="mt-2 px-4 py-1 bg-black text-white rounded hover:bg-gray-800">+ Add Item</button>
                </div>

                <!-- Notes -->
                <div class="bg-white p-6 rounded-xl shadow mb-6">
                    <label class="text-sm font-medium text-gray-600">Notes (Optional)</label>
                    <textarea id="notes_field" name="notes" class="w-full border rounded-lg p-3 mt-2" placeholder="Add any additional notes..."></textarea>
                </div>

                <!-- Buttons -->
                <div class="flex flex-wrap gap-3">
                    <button type="submit" name="status" value="sent" class="px-5 py-2 rounded-lg bg-purple-600 text-white hover:bg-purple-700 transition">Save & Send</button>
                    <button type="submit" name="status" value="draft" class="px-5 py-2 rounded-lg bg-gray-500 text-white hover:bg-gray-600 transition">Save as Draft</button>
                </div>
            </form>
        </main>
    </div>
</div>

<script>
    let index = 1;

    function removeItem(button){
        button.closest('.item-row').remove();
        updateSummary();
    }

    function addItem(){
        const container = document.getElementById('items-container');
        const html = `
            <div class="grid grid-cols-7 gap-3 mb-2 item-row items-end">
                <div class="flex flex-col relative">
                    <input name="items[${index}][description]" placeholder="Description" class="border p-2 rounded description" required>
                    <button type="button" onclick="generateDescription(this)" class="absolute top-0 right-0 mt-1 mr-1 px-2 py-1 bg-blue-500 text-white rounded text-xs hover:bg-blue-600">AI</button>
                </div>
                <div class="flex flex-col">
                    <input name="items[${index}][qty]" type="number" value="1" class="border p-2 rounded qty" min="1" required>
                </div>
                <div class="flex flex-col">
                    <input name="items[${index}][unit_price]" type="number" step="0.01" value="0" class="border p-2 rounded unit_price" required>
                </div>
                <div class="flex flex-col">
                    <input name="items[${index}][tax]" type="number" step="0.01" value="0" class="border p-2 rounded tax">
                </div>
                <div class="flex flex-col">
                    <input name="items[${index}][discount]" type="number" step="0.01" value="0" class="border p-2 rounded discount">
                </div>
                <div class="flex flex-col">
                    <input type="text" value="RS0.00" readonly class="border p-2 rounded bg-gray-100 text-gray-500 total">
                </div>
                <div class="flex flex-col">
                    <button type="button" onclick="removeItem(this)" class="p-2 bg-red-500 text-white rounded hover:bg-red-600 flex items-center justify-center">✕</button>
                </div>
            </div>`;
        container.insertAdjacentHTML('beforeend', html);
        index++;
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
            row.querySelector('.total').value = 'RS' + ((qty*price)+tax-discount).toFixed(2);
        });
        const grandTotal = subtotal + totalTax - totalDiscount;
        document.getElementById('subtotal').innerText = 'RS' + subtotal.toFixed(2);
        document.getElementById('total-tax').innerText = 'RS' + totalTax.toFixed(2);
        document.getElementById('total-discount').innerText = 'RS' + totalDiscount.toFixed(2);
        document.getElementById('grand-total').innerText = 'RS' + grandTotal.toFixed(2);
    }

    document.querySelectorAll('.qty, .unit_price, .tax, .discount').forEach(el => {
        el.addEventListener('input', updateSummary);
    });

    // ---------------- AI DESCRIPTION ----------------
    function generateDescription(button){
        const row = button.closest('.item-row');
        const title = document.querySelector('input[name="title"]').value;

        if(!title){
            alert('Please enter quotation title first!');
            return;
        }

        button.disabled = true;
        button.innerText = 'Generating...';

        fetch("{{ route('quotations.generateDescription') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ title })
        })
        .then(res => res.json())
        .then(data => {
            if(data.description){
                row.querySelector('.description').value = data.description;
            } else {
                alert('AI failed to generate description');
            }
        })
        .catch(err => {
            console.error(err);
            alert('AI request failed');
        })
        .finally(() => {
            button.disabled = false;
            button.innerText = 'AI';
        });
    }
</script>
</body>
</html>
