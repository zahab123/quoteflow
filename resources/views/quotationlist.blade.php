<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quotations - QuoteFlow</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body class="h-full bg-gray-100 flex flex-col md:flex-row">

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
                        {{ request()->is('admin/dashboard') 
                            ? 'bg-gradient-to-r from-purple-600 to-pink-500 text-white shadow' 
                            : 'hover:bg-gray-100 text-gray-700' }}">
                    <x-heroicon-o-home class="w-5 h-5 mr-3" />
                    Dashboard
                </a>
            </li>
            <li>
                <a href="/clientlist"
                   class="flex items-center px-6 py-3 transition rounded-lg
                        {{ request()->is('clientlist') 
                            ? 'bg-gradient-to-r from-purple-600 to-pink-500 text-white shadow' 
                            : 'hover:bg-gray-100 text-gray-700' }}">
                    <x-heroicon-o-users class="w-5 h-5 mr-3" />
                    Clients
                </a>
            </li>
            <li>
                <a href="{{ route('quotationlist') }}"
                   class="flex items-center px-6 py-3 transition rounded-lg
                        {{ request()->is('quotationlist') 
                            ? 'bg-gradient-to-r from-purple-600 to-pink-500 text-white shadow' 
                            : 'hover:bg-gray-100 text-gray-700' }}">
                    <x-heroicon-o-document-text class="w-5 h-5 mr-3" />
                    Quotations
                </a>
            </li>
            <li>
                <a href="/reports"
                   class="flex items-center px-6 py-3 transition rounded-lg
                        {{ request()->is('reports') 
                            ? 'bg-gradient-to-r from-purple-600 to-pink-500 text-white shadow' 
                            : 'hover:bg-gray-100 text-gray-700' }}">
                    <x-heroicon-o-chart-bar class="w-5 h-5 mr-3" />
                    Reports
                </a>
            </li>
            <li>
                <a href="/settings"
                   class="flex items-center px-6 py-3 transition rounded-lg
                        {{ request()->is('settings') 
                            ? 'bg-gradient-to-r from-purple-600 to-pink-500 text-white shadow' 
                            : 'hover:bg-gray-100 text-gray-700' }}">
                    <x-heroicon-o-cog class="w-5 h-5 mr-3" />
                    Settings
                </a>
            </li>
        </ul>

        <!-- User Profile -->
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
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-end h-16 items-center space-x-6">
                    <!-- Profile Button -->
                    <div x-data="{ open: false }" class="relative">
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
        </nav>

        <!-- Main content -->
        <main class="flex-1 p-4 md:p-10 overflow-auto bg-gray-50">
            <!-- Header -->
            <div class="mb-6 flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">Quotations</h1>
                    <p class="text-sm text-gray-500">Manage all your quotations and proposals</p>
                </div>
                <a href="{{ route('quotations') }}" class="px-4 py-2 bg-gradient-to-r from-purple-600 to-pink-500 text-white rounded-lg hover:opacity-90 shadow-md transition">
                    + New Quotation
                </a>
            </div>

            <!-- Messages -->
            @if(session('success'))
                <div class="mb-4 p-4 text-green-800 bg-green-100 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 p-4 text-red-800 bg-red-100 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Search / Filters -->
            <div class="mb-6 flex flex-col md:flex-row gap-4">
                <input type="text" placeholder="Search quotations..."
                       class="w-full md:w-1/3 px-4 py-2 rounded-lg border border-gray-200 shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"/>
                <select class="w-full md:w-48 px-4 py-2 rounded-lg border border-gray-200 shadow-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    <option value="">All Status</option>
                    <option value="Approved">Approved</option>
                    <option value="Pending">Pending</option>
                    <option value="Rejected">Rejected</option>
                </select>
            </div>

            <!-- Quotations grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($quotations as $quotation)
                    <div class="bg-white rounded-xl shadow p-6 flex flex-col justify-between transition hover:shadow-lg">
                        <div class="mb-4">
                            <div class="flex justify-between items-center mb-3">
                                <h2 class="font-bold text-lg text-gray-800">Quotation #{{ $quotation->id }}</h2>
                                <span class="text-xs font-semibold px-3 py-1 rounded-full
                                    @if($quotation->status == 'Approved') bg-green-100 text-green-700
                                    @elseif($quotation->status == 'Pending') bg-yellow-100 text-yellow-700
                                    @else bg-gray-100 text-gray-600 @endif">
                                    {{ $quotation->status }}
                                </span>
                            </div>
                            <p class="text-gray-700 mb-1"><span class="font-semibold">Client:</span> {{ $quotation->client->name ?? 'N/A' }}</p>
                            <p class="text-gray-700 mb-1"><span class="font-semibold">Date:</span> {{ $quotation->created_at->format('Y-m-d') }}</p>
                            <p class="text-gray-700 mb-1"><span class="font-semibold">Items:</span> {{ optional($quotation->items)->count() ?? 0 }}</p>
                            <p class="text-gray-700"><span class="font-semibold">Total Amount:</span> <span class="text-purple-600 font-bold">${{ $quotation->total }}</span></p>
                        </div>
                        <div class="mt-4 flex space-x-2">
                            <a href="{{ route('view', $quotation->id) }}" class="flex items-center px-3 py-2 bg-blue-50 text-blue-600 text-sm font-medium rounded-lg hover:bg-blue-100 transition">View</a>

                            <!-- Edit button links to your simple route -->
                            
                            <a href="{{ route('editquotation', $quotation->id) }}" class="px-3 py-2 bg-gray-50 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-100 transition">Edit</a>

                            <!-- Delete button with confirmation -->
                            <form action="{{ route('quotations.delete', $quotation->id) }}" method="POST"
                                  onsubmit="return confirm('Are you sure you want to delete this quotation?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-2 bg-red-50 text-red-600 text-sm font-medium rounded-lg hover:bg-red-100 transition">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 col-span-3 text-center py-10">No quotations found.</p>
                @endforelse
            </div>

        </main>
    </div>

</body>
</html>
