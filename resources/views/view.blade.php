<!DOCTYPE html>
<html lang="en" x-data="{ darkMode: false, sidebarOpen: false }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Quotation - Professional</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <style>
        @media print {
            .a4-page { width: 210mm; min-height: 297mm; margin: 0; page-break-after: always; }
            .no-print { display: none !important; }
        }
        .a4-container { max-width: 210mm; }
        .gradient-bg { background: linear-gradient(135deg, #6366F1, #EC4899); }
    </style>
</head>
<body class="h-screen flex bg-gray-50">
    <!-- Sidebar Overlay -->
    <div x-show="sidebarOpen" @click="sidebarOpen = false"
         class="fixed inset-0 bg-gray-600 bg-opacity-75 z-40 md:hidden"
         x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"></div>

    <!-- Sidebar -->
    <aside class="fixed inset-y-0 left-0 z-50 w-60 bg-white h-screen shadow-md border-r flex flex-col
                  transform md:translate-x-0 md:static md:flex-shrink-0"
           :class="{ 'translate-x-0 ease-out': sidebarOpen, '-translate-x-full ease-in': !sidebarOpen }"
           x-transition:enter="transition ease-out duration-300"
           x-transition:leave="transition ease-in duration-300">
        <!-- Logo & Title -->
        <div class="px-6 py-6 flex items-center gap-2 border-b">
            <button @click="sidebarOpen = false" class="md:hidden mr-3 text-gray-500 hover:text-gray-800">
                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
            <img src="{{ asset('images/logo.PNG') }}" alt="Logo" class="w-10 h-10 object-contain">
            <span class="text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-purple-600 via-blue-500 to-pink-500">
                QuoteFlow
            </span>
        </div>

        <!-- Navigation -->
        <ul class="mt-4 flex-1 overflow-y-auto text-gray-700 font-medium">
            <li>
                <a href="/admin/dashboard"
                   class="flex items-center px-6 py-3 transition rounded-lg
                          {{ request()->is('admin/dashboard') 
                              ? 'bg-gradient-to-r from-purple-600 to-pink-500 text-white shadow' 
                              : 'hover:bg-gray-100 text-gray-700' }}">
                    <x-heroicon-o-home class="w-5 h-5 mr-3" /> Dashboard
                </a>
            </li>
            <li>
                <a href="/clientlist"
                   class="flex items-center px-6 py-3 transition rounded-lg
                          {{ request()->is('clientlist') 
                              ? 'bg-gradient-to-r from-purple-600 to-pink-500 text-white shadow' 
                              : 'hover:bg-gray-100 text-gray-700' }}">
                    <x-heroicon-o-users class="w-5 h-5 mr-3" /> Clients
                </a>
            </li>
            <li>
                <a href="{{ route('quotationlist') }}"
                   class="flex items-center px-6 py-3 transition rounded-lg
                          {{ request()->is('quotationlist') 
                              ? 'bg-gradient-to-r from-purple-600 to-pink-500 text-white shadow' 
                              : 'hover:bg-gray-100 text-gray-700' }}">
                    <x-heroicon-o-document-text class="w-5 h-5 mr-3" /> Quotations
                </a>
            </li>
            <li>
                <a href="/report"
                   class="flex items-center px-6 py-3 transition rounded-lg
                          {{ request()->is('reports') 
                              ? 'bg-gradient-to-r from-purple-600 to-pink-500 text-white shadow' 
                              : 'hover:bg-gray-100 text-gray-700' }}">
                    <x-heroicon-o-chart-bar class="w-5 h-5 mr-3" /> Reports
                </a>
            </li>
            <li>
                <a href="/setting"
                   class="flex items-center px-6 py-3 transition rounded-lg
                          {{ request()->is('settings') 
                              ? 'bg-gradient-to-r from-purple-600 to-pink-500 text-white shadow' 
                              : 'hover:bg-gray-100 text-gray-700' }}">
                    <x-heroicon-o-cog class="w-5 h-5 mr-3" /> Settings
                </a>
            </li>
        </ul>

        <!-- Profile -->
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
    <div class="flex-1 flex flex-col overflow-y-auto">
        <!-- Navbar -->
        <nav class="bg-white border-b border-gray-200 shadow-sm">
            <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16 items-center">
                    <div class="flex items-center space-x-4">
                        <button @click="sidebarOpen = true" class="text-gray-500 hover:text-gray-800 md:hidden">
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                        <h1 class="text-xl font-semibold text-gray-800 hidden sm:block">View Quotation</h1>
                        <div class="relative w-full">
                            <input type="text" placeholder="Search..."
                                   class="pl-10 pr-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent outline-none w-40 sm:w-64">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1010.5 3a7.5 7.5 0 006.15 13.65z" />
                            </svg>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3 sm:space-x-6">
                        <!-- Notifications and Profile -->
                        <button class="relative p-2 rounded-full hover:bg-gray-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M15 17h5l-1.405-1.405C18.21 15.21 18 14.11 18 13V9a6 6 0 10-12 0v4c0 
                                         1.11-.21 2.21-.595 3.595L4 17h5m6 0v1a3 3 
                                         0 11-6 0v-1m6 0H9" />
                            </svg>
                            <span class="absolute top-0 right-0 w-2 h-2 bg-red-500 rounded-full"></span>
                        </button>
                        <div x-data="{ open: false }" class="relative hidden sm:block">
                            <button @click="open = !open"
                                    class="w-10 h-10 rounded-full bg-gradient-to-r from-purple-600 to-pink-500 hover:ring-2 ring-purple-400 flex items-center justify-center text-white text-lg font-bold">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </button>
                            <div x-show="open" @click.away="open = false"
                                 class="absolute right-0 mt-2 w-48 bg-white border rounded shadow-lg z-50">
                                <x-dropdown-link :href="route('profile.edit')" class="block px-4 py-2 hover:bg-gray-100">
                                    Profile
                                </x-dropdown-link>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')" class="block px-4 py-2 hover:bg-gray-100"
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
 @php
                                    $totalPaid = $quotation->payments->sum('amount');
                                    $remainingAmount = $quotation->total - $totalPaid;
                                @endphp
        <!-- Main Quotation Content -->
        <main class="flex-1 p-4 md:p-10 overflow-auto" x-data="{ selectedDesign: 'minimal', quotation: {{ json_encode($quotation) }} }">
            <div class="no-print mb-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">View Quotation</h1>
                    <p class="text-sm text-gray-500">Detailed view of quotation #{{ $quotation->id }}</p>
                </div>

                <div class="flex flex-wrap gap-2">
                    <!-- Back, Download, Send Email, Add Payment buttons -->
                    <a href="{{ route('quotationlist') }}" 
                       class="px-4 py-2 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400 shadow-md transition">
                        Back to List
                    </a>
                    <a href="{{ route('quotations.download', $quotation->id) }}" target="_blank"
                       class="px-4 py-2 bg-gradient-to-r from-purple-600 to-pink-500 text-white rounded-lg hover:opacity-90 shadow-md transition">
                        Download PDF
                    </a>
                    <form action="{{ route('quotations.sendEmail', $quotation->id) }}" method="GET">
                        <button type="submit" 
                                class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 shadow-md transition flex items-center gap-1">
                            Send Email
                        </button>
                    </form>

                    <!-- Add Payment Toggle & Modal Form -->
                    <div x-data="{ showPayment: false }">
                        <button @click="showPayment = true"
                                class="px-4 py-2 bg-gradient-to-r from-purple-600 to-pink-500 text-white rounded-lg hover:opacity-90 shadow-md transition"
                                @click.prevent="{{ $remainingAmount <= 0 ? '' : 'showPayment = true' }}">
                            Add Payment
                        </button>
                        <!-- Modal -->
                        <div x-show="showPayment" x-transition
                             class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
                             style="display: none;">
                            <div class="bg-white w-96 p-6 rounded-lg shadow-lg relative">
                                <button @click="showPayment = false"
                                        class="absolute top-2 right-2 text-gray-500 hover:text-gray-700 font-bold text-lg">
                                    &times;
                                </button>
                                <h3 class="text-xl font-bold text-gray-800 mb-4">Add Payment</h3>
                               
                                @if($remainingAmount <= 0)
                                    <div class="p-4 bg-green-100 text-green-800 rounded">
                                        Client has already fully paid.
                                    </div>
                                @else
                                    <form action="{{ route('payments.store', $quotation->id) }}" method="POST" class="space-y-3">
                                        @csrf
                                        <div>
                                            <label class="block font-semibold text-gray-700 mb-1">Amount Paid</label>
                                            <input type="number" step="0.01" name="amount" 
                                                   class="w-full border border-gray-300 p-2 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent outline-none"
                                                   placeholder="Enter payment amount" 
                                                   value="{{ $remainingAmount }}" 
                                                   min="1" max="{{ $remainingAmount }}" required>
                                            <small class="text-gray-500">Remaining amount: RS{{ number_format($remainingAmount, 2) }}</small>
                                        </div>
                                        <div>
                                            <label class="block font-semibold text-gray-700 mb-1">Payment Method</label>
                                            <select name="payment_method"
                                                    class="w-full border border-gray-300 p-2 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent outline-none">
                                                <option value="Cash">Cash</option>
                                                <option value="Bank Transfer">Bank Transfer</option>
                                                <option value="EasyPaisa">EasyPaisa</option>
                                                <option value="JazzCash">JazzCash</option>
                                            </select>
                                        </div>
                                        <button type="submit" 
                                                class="w-full bg-gradient-to-r from-purple-600 to-pink-500 text-white px-4 py-2 rounded-lg shadow-md hover:opacity-90 transition">
                                            Add Payment
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Design Selector -->
            <div class="no-print mb-6 max-w-4xl mx-auto">
                <h2 class="text-xl font-semibold mb-3 text-gray-800">Select Quotation Summary Design</h2>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
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

            <!-- Quotation Container -->
            <div class="a4-container mx-auto bg-white rounded-xl shadow-xl p-8 lg:p-12 mb-10 a4-page">
                <!-- Company & Quotation Header -->
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center border-b-2 border-gray-200 pb-4 mb-8 gap-4">
                    <div class="flex flex-col items-start gap-3">
    <!-- Company Logo -->
    <div class="w-24 h-24 rounded-full overflow-hidden shadow-lg flex items-center justify-center bg-white">
        @if(!empty($company->logo))
            <img src="{{ asset('storage/' . $company->logo) }}" alt="Logo" class="w-full h-full object-contain p-1">
        @else
            <img src="{{ asset('images/logo.PNG') }}" alt="Default Logo" class="w-full h-full object-contain p-1">
        @endif
    </div>

    <!-- Company Details -->
    <div class="text-left">
        <div class="text-lg font-bold text-purple-600">{{ $company->company_name ?? 'Your Company Name' }}</div>
        <div class="text-sm text-gray-600">Phone: {{ $company->phone ?? '' }}</div>
        <div class="text-sm text-gray-600">Email: {{ $company->email ?? '' }}</div>
        <div class="text-sm text-gray-600">Website: {{ $company->website ?? '' }}</div>
        <div class="text-sm text-gray-600">Address: {{ $company->address ?? '' }}</div>
    </div>
</div>
<div class="text-right">
                        <div class="text-3xl font-extrabold text-gray-800 mb-1">QUOTATION</div>
                        <div class="text-sm text-purple-600 font-semibold">#{{ $quotation->id }}</div>
                    </div>
                </div>

                <!-- Billed To & Dates -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                    <div>
                        <h3 class="font-semibold text-lg text-purple-600 mb-2 border-b border-purple-200 inline-block">Billed To</h3>
                        <p class="font-bold text-gray-800 text-xl">Name: {{ $quotation->client->name ?? 'N/A' }}</p>
                        <p class="text-gray-600">Email: {{ $quotation->client->email ?? 'N/A' }}</p>
                        <p class="text-gray-600">Address: {{ $quotation->client->address ?? 'N/A' }}</p>
                    </div>
                    <div class="text-right">
                        <div class="mb-2"><span class="font-semibold text-gray-700">Quotation Date:</span> <span class="font-medium">{{ $quotation->created_at->format('Y-m-d') }}</span></div>
                        <div class="mb-2"><span class="font-semibold text-gray-700">Due Date:</span> <span class="font-medium">{{ $quotation->due_date ?? 'N/A' }}</span></div>
                        <div class="mb-2"><span class="font-semibold text-gray-700">Status:</span> <span class="font-bold text-green-600">{{ $quotation->status }}</span></div>
                    </div>
                </div>

                <!-- Items Table -->
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
                                <td class="px-4 py-3">RS{{ number_format($item->unit_price,2) }}</td>
                                <td class="px-4 py-3">RS{{ number_format($item->tax,2) }}</td>
                                <td class="px-4 py-3">RS{{ number_format($item->discount,2) }}</td>
                                <td class="px-4 py-3 font-bold">RS{{ number_format($item->total,2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Totals -->
                <div class="flex justify-end gap-4 text-gray-700">
                    <div class="w-64">
                        <div class="flex justify-between mb-2">
                            <span>Subtotal:</span>
                            <span>RS{{ number_format($quotation->subtotal,2) }}</span>
                        </div>
                        <div class="flex justify-between mb-2">
                            <span>Tax:</span>
                            <span>RS{{ number_format($quotation->tax,2) }}</span>
                        </div>
                        <div class="flex justify-between mb-2">
                            <span>Discount:</span>
                            <span>RS{{ number_format($quotation->discount,2) }}</span>
                        </div>
                        <div class="flex justify-between font-bold text-lg mt-3 border-t pt-2">
                            <span>Total Payable:</span>
                            <span>RS{{ number_format($remainingAmount,2) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Payment History -->
                <div class="mt-12 border-t pt-6 space-y-6">
                    <h3 class="text-xl font-bold mb-4 text-gray-800">Payment History</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border border-gray-200 rounded-lg overflow-hidden">
                            <thead class="gradient-bg text-white">
                                <tr>
                                    <th class="px-4 py-3 font-semibold">Amount</th>
                                    <th class="px-4 py-3 font-semibold">Method</th>
                                    <th class="px-4 py-3 font-semibold">Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($quotation->payments ?? [] as $payment)
                                    <tr class="{{ $loop->even ? 'bg-gray-50' : '' }}">
                                        <td class="px-4 py-3 font-medium">RS{{ number_format($payment->amount, 2) }}</td>
                                        <td class="px-4 py-3">{{ $payment->payment_method }}</td>
                                        <td class="px-4 py-3">{{ $payment->created_at->format('d M Y') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center py-4 text-gray-500">No payments recorded yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Accept/Decline -->
            <div class="flex flex-col md:flex-row justify-center gap-4 mt-8">
                <form action="{{ route('quotation.status.update', $quotation->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="status" value="accepted">
                    <input type="hidden" name="remarks" value="Accepted by client">
                    <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded hover:bg-green-700 w-full md:w-auto">
                        Accept
                    </button>
                </form>

                <form action="{{ route('quotation.status.update', $quotation->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="status" value="declined">
                    <input type="hidden" name="remarks" value="Declined by client">
                    <button type="submit" class="px-6 py-2 bg-red-600 text-white rounded hover:bg-red-700 w-full md:w-auto">
                        Decline
                    </button>
                </form>
            </div>
        </main>
    </div>
</body>
</html>
