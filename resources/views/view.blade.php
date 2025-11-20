<!DOCTYPE html>
<html lang="en" x-data="{ darkMode: false }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Quotation - Professional</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    <style>
        @media print {
            .a4-page {
                width: 210mm;
                min-height: 297mm;
                margin: 0;
                page-break-after: always;
            }
            .no-print { display: none !important; }
        }
        .a4-container { max-width: 210mm; }
        .gradient-bg { background: linear-gradient(135deg, #6366F1, #EC4899); }
    </style>
    <style>
@media print {
    body * {
        visibility: hidden;
    }
    .a4-page, .a4-page * {
        visibility: visible;
    }
    .a4-page {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
    }
}
</style>

</head>
<body class="h-full bg-gray-100 flex">
    <aside class="w-64 bg-white h-screen shadow-md flex flex-col justify-between">
      <div class="px-6 py-6 flex items-center gap-2 border-b">
            <img src="{{ asset('images/logo.PNG') }}" alt="Logo" class="w-10 h-10 object-contain">
            <span class="text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-purple-600 via-blue-500 to-pink-500">
                QuoteFlow
            </span>
        </div>
        <nav class="flex-1 px-4 py-6">
            <ul class="space-y-2">
                <li><a href="/admin/dashboard" class="flex items-center px-4 py-3 rounded-lg transition {{ request()->is('admin/dashboard') ? 'bg-purple-600 text-white' : 'hover:bg-gray-100 text-gray-700' }}">
                    <x-heroicon-o-home class="w-5 h-5 mr-3" /> Dashboard
                </a></li>

                <li><a href="/clientlist" class="flex items-center px-4 py-3 rounded-lg transition {{ request()->is('clientlist') ? 'bg-purple-600 text-white' : 'hover:bg-gray-100 text-gray-700' }}">
                    <x-heroicon-o-users class="w-5 h-5 mr-3" /> Clients
                </a></li>

                <li><a href="{{ route('quotationlist') }}" class="flex items-center px-4 py-3 rounded-lg transition {{ request()->is('quotationlist') ? 'bg-purple-600 text-white' : 'hover:bg-gray-100 text-gray-700' }}">
                    <x-heroicon-o-document-text class="w-5 h-5 mr-3" /> Quotations
                </a></li>

                <li><a href="/reports" class="flex items-center px-4 py-3 rounded-lg transition {{ request()->is('reports') ? 'bg-purple-600 text-white' : 'hover:bg-gray-100 text-gray-700' }}">
                    <x-heroicon-o-chart-bar class="w-5 h-5 mr-3" /> Reports
                </a></li>

                <li><a href="/settings" class="flex items-center px-4 py-3 rounded-lg transition {{ request()->is('settings') ? 'bg-purple-600 text-white' : 'hover:bg-gray-100 text-gray-700' }}">
                    <x-heroicon-o-cog class="w-5 h-5 mr-3" /> Settings
                </a></li>
            </ul>
        </nav>

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
    <div class="flex-1 flex flex-col">
        <header class="bg-white shadow-sm border-b">
            <div class="flex justify-end items-center h-16 px-6 gap-4">
                <button class="p-2 rounded-full hover:bg-gray-100">
                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M15 17h5l-1.405-1.405C18.21 15.21 18 14.11 18 13V9a6 6 0 10-12 0v4c0 
                              1.11-.21 2.21-.595 3.595L4 17h5m6 0v1a3 3 
                              0 11-6 0v-1m6 0H9" />
                    </svg>
                </button>
                <button @click="darkMode = !darkMode" class="p-2 rounded-full hover:bg-gray-100">
                    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 3v1m0 16v1m8.485-8.485l-.707.707M4.222 
                              4.222l-.707.707M21 12h-1M4 12H3m16.485 
                              4.485l-.707-.707M4.222 19.778l-.707-.707M16 
                              12a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </button>
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" class="w-10 h-10 rounded-full bg-purple-600 text-white text-lg font-bold flex items-center justify-center">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </button>
                    <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white border rounded shadow-lg z-50">
                        <x-dropdown-link :href="route('profile.edit')" class="px-4 py-2 block hover:bg-gray-100">Profile</x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" class="px-4 py-2 block hover:bg-gray-100" onclick="event.preventDefault(); this.closest('form').submit();">Log Out</x-dropdown-link>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <main class="flex-1 p-4 md:p-10 overflow-auto bg-gray-50" x-data="{ selectedDesign: 'minimal', quotation: {{ json_encode($quotation) }} }">
            <div class="no-print mb-6 flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">View Quotation</h1>
                    <p class="text-sm text-gray-500">Detailed view of quotation #{{ $quotation->id }}</p>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('quotationlist') }}" class="px-4 py-2 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400 shadow-md transition">Back to List</a>
                    @if($quotation->pdf_path)
                    <a href="{{ asset('storage/'.$quotation->pdf_path) }}" target="_blank"
                       class="px-4 py-2 bg-gradient-to-r from-purple-600 to-pink-500 text-white rounded-lg hover:opacity-90 shadow-md transition">
                        Download PDF
                    </a>
                    @endif
                    <button onclick="window.print()"
                      class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 shadow-md transition flex items-center gap-1">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                      <path fill-rule="evenodd" d="M5 4v3H4a2 2 0 00-2 2v6a2 2 0 002 2h12a2 2 0 002-2v-6a2 2 0 00-2-2h-1V4a2 2 0 00-2-2H7a2 2 0 00-2 2zm10 2V4a1 1 0 00-1-1H7a1 1 0 00-1 1v2h9zM4 9h12v6h-4v-1a1 1 0 00-1-1H9a1 1 0 00-1 1v1H4V9z" clip-rule="evenodd" />
                    </svg>
                        Print
                    </button>

                </div>
            </div>>
            <div class="no-print mb-6 max-w-4xl mx-auto">
                <h2 class="text-xl font-semibold mb-3 text-gray-800">Select Quotation Summary Design</h2>
                <div class="grid grid-cols-3 gap-4">
                    <button @click="selectedDesign = 'minimal'"
                            :class="{'ring-4 ring-purple-500 ring-offset-2': selectedDesign === 'minimal', 'hover:shadow-lg': selectedDesign !== 'minimal'}"
                            class="p-4 rounded-lg bg-white shadow-md text-left transition duration-150 border">
                        <div class="font-bold text-lg mb-1">Minimal</div>
                        <p class="text-sm text-gray-500">Clean, simple, and direct.</p>
                    </button>
                    <button @click="selectedDesign = 'bordered'"
                            :class="{'ring-4 ring-purple-500 ring-offset-2': selectedDesign === 'bordered', 'hover:shadow-lg': selectedDesign !== 'bordered'}"
                            class="p-4 rounded-lg bg-white shadow-md text-left transition duration-150 border border-purple-400">
                        <div class="font-bold text-lg mb-1">Bordered</div>
                        <p class="text-sm text-gray-500">Highlights separation with structure.</p>
                    </button>
                    <button @click="selectedDesign = 'elegant'"
                            :class="{'ring-4 ring-purple-500 ring-offset-2': selectedDesign === 'elegant', 'hover:shadow-lg': selectedDesign !== 'elegant'}"
                            class="p-4 rounded-lg bg-white shadow-xl text-left transition duration-150 border">
                        <div class="font-bold text-lg mb-1">Elegant Shadow</div>
                        <p class="text-sm text-gray-500">Prominent, floating design.</p>
                    </button>
                </div>
            </div>
            <div class="no-print grid grid-cols-1 md:grid-cols-3 gap-6 mb-8 max-w-4xl mx-auto">
                <div x-show="selectedDesign === 'minimal'" class="p-6 rounded-lg bg-white shadow-sm border">
                    <h2 class="font-bold text-lg mb-4 text-gray-700">Client Details</h2>
                    <p><span class="font-semibold text-gray-600">Client:</span> {{ $quotation->client->name ?? 'N/A' }}</p>
                    <p><span class="font-semibold text-gray-600">Date:</span> {{ $quotation->created_at->format('Y-m-d') }}</p>
                    <p><span class="font-semibold text-gray-600">Status:</span> <span class="text-green-600 font-bold">{{ $quotation->status }}</span></p>
                </div>
                <div x-show="selectedDesign === 'bordered'" class="p-6 border border-2 border-purple-500 rounded-lg bg-white shadow-sm">
                    <h2 class="font-bold text-lg mb-4 text-purple-600">Financial Summary</h2>
                    <p><span class="font-semibold">Total Amount:</span> <span class="text-xl font-bold text-purple-700">${{ number_format($quotation->total, 2) }}</span></p>
                    <p><span class="font-semibold">Tax:</span> ${{ number_format($quotation->tax, 2) }}</p>
                    <p><span class="font-semibold">Discount:</span> ${{ number_format($quotation->discount, 2) }}</p>
                </div>
                <div x-show="selectedDesign === 'elegant'" class="p-6 rounded-xl bg-white shadow-2xl">
                    <h2 class="font-bold text-lg mb-4 text-pink-600">Key Metrics</h2>
                    <p><span class="font-semibold">Items:</span> {{ $quotation->items->count() ?? 0 }}</p>
                    <p><span class="font-semibold">Viewed At:</span> <span class="text-sm">{{ $quotation->viewed_at ?? 'Not Viewed' }}</span></p>
                    <p><span class="font-semibold">Sent At:</span> <span class="text-sm">{{ $quotation->sent_at ?? 'Not Sent' }}</span></p>
                </div>
            </div>
            <div class="a4-container mx-auto bg-white rounded-xl shadow-xl p-8 lg:p-12 mb-10 a4-page">
                <div class="flex justify-between items-start border-b-2 border-gray-200 pb-4 mb-8">
                    <div>
                        <div class="text-3xl font-extrabold text-gray-800">QUOTATION</div>
                        <div class="text-sm text-gray-500">#{{ $quotation->id }}</div>
                    </div>
                    <div class="text-right">
                        <div class="w-16 h-16 rounded-full flex items-center justify-center text-white font-extrabold text-2xl gradient-bg shadow-lg">QF</div>
                        <div class="text-lg font-bold text-purple-600">QuoteFlow Solutions</div>
                        <div class="text-sm text-gray-600">123 Business Blvd, Suite 400</div>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-8 mb-8">
                    <div>
                        <h3 class="font-semibold text-lg text-purple-600 mb-2 border-b border-purple-200 inline-block">Billed To</h3>
                        <p class="font-bold text-gray-800 text-xl">{{ $quotation->client->name ?? 'N/A' }}</p>
                        <p class="text-gray-600">{{ $quotation->client->email ?? 'N/A' }}</p>
                        <p class="text-gray-600">{{ $quotation->client->address ?? 'N/A' }}</p>
                    </div>
                    <div class="text-right">
                        <div class="mb-2"><span class="font-semibold text-gray-700">Quotation Date:</span> <span class="font-medium">{{ $quotation->created_at->format('Y-m-d') }}</span></div>
                        <div class="mb-2"><span class="font-semibold text-gray-700">Due Date:</span> <span class="font-medium">{{ $quotation->due_date ?? 'N/A' }}</span></div>
                        <div class="mb-2"><span class="font-semibold text-gray-700">Status:</span> <span class="font-bold text-green-600">{{ $quotation->status }}</span></div>
                    </div>
                </div>
                <div class="mb-8 shadow-md rounded-lg overflow-hidden border border-gray-200">
                    <table class="w-full text-left">
                        <thead class="gradient-bg text-white">
                            <tr>
                                <th class="px-4 py-3 font-semibold">#</th>
                                <th class="px-4 py-3 font-semibold">Item Description</th>
                                <th class="px-4 py-3 font-semibold">Qty</th>
                                <th class="px-4 py-3 font-semibold">Unit Price</th>
                                <th class="px-4 py-3 font-semibold">Tax</th>
                                <th class="px-4 py-3 font-semibold">Discount</th>
                                <th class="px-4 py-3 font-semibold">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($quotation->items as $key => $item)
                            <tr class="{{ $key % 2 == 0 ? 'bg-gray-50' : '' }}">
                                <td class="px-4 py-3">{{ $key + 1 }}</td>
                                <td class="px-4 py-3">{{ $item->description }}</td>
                                <td class="px-4 py-3">{{ $item->qty }}</td>
                                <td class="px-4 py-3">${{ number_format($item->unit_price,2) }}</td>
                                <td class="px-4 py-3">${{ number_format($item->tax,2) }}</td>
                                <td class="px-4 py-3">${{ number_format($item->discount,2) }}</td>
                                <td class="px-4 py-3 font-bold">${{ number_format($item->total,2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="flex justify-end gap-4 text-gray-700">
                    <div class="w-64">
                        <div class="flex justify-between mb-2">
                            <span>Subtotal:</span>
                            <span>${{ number_format($quotation->subtotal,2) }}</span>
                        </div>
                        <div class="flex justify-between mb-2">
                            <span>Tax:</span>
                            <span>${{ number_format($quotation->tax,2) }}</span>
                        </div>
                        <div class="flex justify-between mb-2">
                            <span>Discount:</span>
                            <span>${{ number_format($quotation->discount,2) }}</span>
                        </div>
                        <div class="flex justify-between font-bold text-lg mt-3 border-t pt-2">
                            <span>Total:</span>
                            <span>${{ number_format($quotation->total,2) }}</span>
                        </div>
                    </div>
                </div>

                <div class="mt-12 text-center text-gray-500 text-sm">
                    Thank you for doing business with us!
                </div>
            </div>
        </main>

    </div>
</body>
</html>

<script>
function printQuotation() {
    const printContent = document.querySelector('.a4-page').innerHTML;
    const originalContent = document.body.innerHTML;
    document.body.innerHTML = printContent;
    window.print();
    document.body.innerHTML = originalContent;
    window.location.reload();
}
</script>