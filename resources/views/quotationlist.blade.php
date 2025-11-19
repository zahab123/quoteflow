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
            <a href="/report"
               class="flex items-center px-6 py-3 transition rounded-lg
                    {{ request()->is('reports') 
                        ? 'bg-gradient-to-r from-purple-600 to-pink-500 text-white shadow' 
                        : 'hover:bg-gray-100 text-gray-700' }}">
                <x-heroicon-o-chart-bar class="w-5 h-5 mr-3" />
                Reports
            </a>
        </li>
        <li>
            <a href="/setting"
               class="flex items-center px-6 py-3 transition rounded-lg
                    {{ request()->is('settings') 
                        ? 'bg-gradient-to-r from-purple-600 to-pink-500 text-white shadow' 
                        : 'hover:bg-gray-100 text-gray-700' }}">
                <x-heroicon-o-cog class="w-5 h-5 mr-3" />
                Settings
            </a>
        </li>
    </ul>

    <!-- User Profile bottom -->
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
                <x-dropdown-link :href="route('logout')"
                                 onclick="event.preventDefault(); this.closest('form').submit();">
                    Log Out
                </x-dropdown-link>
            </form>
        </div>
    </div>
</aside>

<!-- Main Layout -->
<div class="flex-1 flex flex-col">

    <!-- Top Navbar -->
    <nav class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-end h-16 items-center space-x-6">
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open"
                            class="w-10 h-10 rounded-full bg-gradient-to-r from-purple-600 to-pink-500 
                                   hover:ring-2 ring-purple-400 flex items-center justify-center 
                                   text-white text-lg font-bold">
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

    <!-- Page Content -->
    <main class="flex-1 p-4 md:p-10 overflow-auto bg-gray-50">

        <!-- Title -->
        <div class="mb-6 flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-extrabold text-gray-900">Quotations</h1>
                <p class="text-sm text-gray-500">Manage all your quotations and proposals</p>
            </div>

            <a href="{{ route('quotations') }}"
               class="px-4 py-2 bg-gradient-to-r from-purple-600 to-pink-500 
                      text-white rounded-lg hover:opacity-90 shadow-md transition">
                + New Quotation
            </a>
        </div>

        <!-- Success / Error Alerts -->
        @if(session('success'))
            <div class="mb-4 p-4 text-green-800 bg-green-100 rounded shadow">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 p-4 text-red-800 bg-red-100 rounded shadow">
                {{ session('error') }}
            </div>
        @endif

        <!-- Filters -->
        <form method="GET" action="{{ route('quotationlist') }}" class="mb-6 flex flex-col md:flex-row gap-4">
            <input type="text" name="search" placeholder="Search quotations..."
                   value="{{ request('search') }}"
                   class="w-full md:w-1/3 px-4 py-2 rounded-lg border border-gray-300 shadow-sm 
                          focus:outline-none focus:ring-2 focus:ring-purple-500"/>

            <select name="status"
                    class="w-full md:w-48 px-4 py-2 rounded-lg border border-gray-300 shadow-sm 
                           focus:outline-none focus:ring-2 focus:ring-purple-500">
                <option value="">All Status</option>
                <option value="Accepted" {{ request('status')=='Accepted' ? 'selected' : '' }}>Accepted</option>
                <option value="Sent" {{ request('status')=='Sent' ? 'selected' : '' }}>Sent</option>
                <option value="Pending" {{ request('status')=='Pending' ? 'selected' : '' }}>Pending</option>
                <option value="Rejected" {{ request('status')=='Rejected' ? 'selected' : '' }}>Rejected</option>
                <option value="Draft" {{ request('status')=='Draft' ? 'selected' : '' }}>Draft</option>
                <option value="Viewed" {{ request('status')=='Viewed' ? 'selected' : '' }}>Viewed</option>
            </select>

            <button type="submit" 
                    class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:opacity-90 shadow-md transition">
                Filter
            </button>
        </form>

        <!-- Quotations Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

            @forelse($quotations as $quotation)
                <div x-data="{ copied: false }" class="bg-white p-6 rounded-xl shadow-md hover:shadow-xl transition flex flex-col justify-between">

                    <div class="mb-4">
                        <div class="flex justify-between items-center mb-2">
                            <div>
                                <h2 class="text-lg font-semibold text-gray-900">{{ $quotation->title ?? 'Quotation #' . $quotation->id }}</h2>
                                <p class="text-sm text-gray-500">{{ $quotation->client->name ?? 'N/A' }} • {{ $quotation->company ?? '' }}</p>
                            </div>

                            @php
                                $statusClasses = [
                                    'Accepted' => 'bg-green-100 text-green-700',
                                    'Sent'     => 'bg-blue-100 text-blue-700',
                                    'Pending'  => 'bg-yellow-100 text-yellow-700',
                                    'Rejected' => 'bg-red-100 text-red-700',
                                    'Draft'    => 'bg-gray-100 text-gray-700',
                                    'Viewed'   => 'bg-indigo-100 text-indigo-700',
                                ];
                                $statusClass = $statusClasses[$quotation->status] ?? 'bg-gray-100 text-gray-700';
                            @endphp

                            <span class="text-xs font-bold px-3 py-1 rounded-full {{ $statusClass }}">
                                {{ $quotation->status }}
                            </span>
                        </div>

                        <p class="text-sm text-gray-500">Date: {{ $quotation->created_at->format('Y-m-d') }}</p>
                        <p class="text-sm text-gray-500">Items: {{ optional($quotation->items)->count() ?? 0 }}</p>
                        <p class="text-lg font-bold text-purple-600 mt-2">${{ $quotation->total }}</p>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-wrap gap-2 mt-4">

                        <a href="{{ route('view', $quotation->id) }}"
                           class="bg-purple-50 hover:bg-purple-100 text-purple-700 font-semibold py-2 px-4 rounded transition">
                            View
                        </a>

                        <a href="{{ route('editquotation', $quotation->id) }}"
                           class="bg-yellow-50 hover:bg-yellow-100 text-yellow-700 font-semibold py-2 px-4 rounded transition">
                            Edit
                        </a>

                        <!-- Copy Button -->
                        <button @click="copied = true; setTimeout(() => copied = false, 2000)"
                                class="bg-blue-50 hover:bg-blue-100 text-blue-700 font-semibold py-2 px-4 rounded transition relative">
                            Copy
                            <span x-show="copied" x-transition 
                                  class="absolute top-0 right-0 -mt-2 -mr-2 bg-blue-600 text-white text-xs font-bold px-2 py-1 rounded-full">
                                Copied
                            </span>
                        </button>

                        <form action="{{ route('quotations.delete', $quotation->id) }}" method="POST"
                              onsubmit="return confirm('Are you sure you want to delete this quotation?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="bg-red-50 hover:bg-red-100 text-red-700 font-semibold py-2 px-4 rounded transition">
                                Delete
                            </button>
                        </form>

                    </div>

                </div>
            @empty
                <p class="text-gray-500 col-span-3 text-center py-10">No quotations found.</p>
            @endforelse

        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $quotations->withQueryString()->links() }}
        </div>

    </main>
</div>

</body>
</html>
