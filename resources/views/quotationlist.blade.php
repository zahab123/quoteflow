<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quotations - QuoteFlow</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body class="h-full bg-gray-100 flex flex-col" x-data="clientsData()">
    <div x-data="{ sidebarOpen: false }" class="h-full flex"> 
        <div x-show="sidebarOpen" @click="sidebarOpen = false"
             class="fixed inset-0 bg-gray-600 bg-opacity-75 z-40 md:hidden"
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
        </div>

        <aside class="fixed inset-y-0 left-0 z-50 transform w-60 bg-white h-full shadow-md border-r flex flex-col justify-between
                      md:static md:translate-x-0 md:flex-shrink-0
                      "
               :class="{ 'translate-x-0 ease-out': sidebarOpen, '-translate-x-full ease-in': !sidebarOpen }"
               x-transition:enter="transition ease-out duration-300"
               x-transition:leave="transition ease-in duration-300">
            <div class="px-6 py-6 flex items-center gap-2 border-b">
                <button @click="sidebarOpen = false" class="md:hidden mr-3 text-gray-500 hover:text-gray-800">
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
                <img src="{{ asset('images/logo.PNG') }}" alt="Logo" class="w-10 h-10 object-contain">
                <span class="text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-purple-600 via-blue-500 to-pink-500">
                    QuoteFlow
                </span>
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
            <div class="px-6 py-6 flex items-center gap-3 border-t" x-data="{ open: false }">
                <div class="relative">
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
                         class="absolute bottom-full mb-2 left-0 w-48 bg-white border rounded shadow-lg z-50">
                        <x-dropdown-link :href="route('profile.edit')" class="block px-4 py-2 hover:bg-gray-100">Profile</x-dropdown-link>
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
        </aside>

        <div class="flex-1 flex flex-col overflow-y-auto">
            <nav class="bg-white border-b border-gray-200 shadow-sm">
                <div class="max-w-full mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16 items-center">
                        <div class="flex items-center space-x-4">
                            <button @click="sidebarOpen = true" class="text-gray-500 hover:text-gray-800 md:hidden">
                                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                </svg>
                            </button>
                            <h1 class="text-xl font-semibold text-gray-800 **hidden sm:block**">Quotation  Management</h1>
                            <div class="relative **w-full**">
                                <input type="text" placeholder="Search..."
                                       class="pl-10 pr-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent outline-none **w-40 sm:w-64**">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1010.5 3a7.5 7.5 0 006.15 13.65z" />
                                </svg>
                            </div>
                        </div>
                        <div class="flex items-center space-x-3 sm:space-x-6">
                            <button class="relative p-2 rounded-full hover:bg-gray-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M15 17h5l-1.405-1.405C18.21 15.21 18 14.11 18 13V9a6 6 0 10-12 0v4c0 
                                             1.11-.21 2.21-.595 3.595L4 17h5m6 0v1a3 3 
                                             0 11-6 0v-1m6 0H9" />
                                </svg>
                                <span class="absolute top-0 right-0 w-2 h-2 bg-red-500 rounded-full"></span>
                            </button>
                            <button class="p-2 rounded-full hover:bg-gray-100 **hidden sm:block**">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M12 3v1m0 16v1m8.485-8.485l-.707.707M4.222 4.222l-.707.707M21 12h-1M4 
                                             12H3m16.485 4.485l-.707-.707M4.222 19.778l-.707-.707M16 
                                             12a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                            </button>
                            <div x-data="{ open: false }" class="relative **hidden sm:block**">
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
    
    <main class="flex-1 p-4 md:p-10 overflow-auto bg-gray-50">
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
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

    @forelse($quotations as $quotation)

    <div x-data="{ copied: false }" 
        class="w-full bg-white p-6 rounded-xl shadow-lg border border-gray-100 flex flex-col justify-between">

        <!-- Header Section -->
        <div class="mb-4">
            <div class="flex justify-between items-start mb-1">
                <!-- Dynamic Title -->
                <h2 class="text-xl font-semibold text-gray-800 leading-tight pr-4">
                    {{ $quotation->title ?? 'Quotation #' . $quotation->id }}
                </h2>

                <!-- Status Badge -->
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

                <span class="text-xs font-medium px-3 py-1 rounded-full whitespace-nowrap {{ $statusClass }}">
                    {{ $quotation->status }}
                </span>
            </div>

            <!-- Client Info -->
            <p class="text-sm text-gray-500">
                {{ $quotation->client->name ?? 'N/A' }} • {{ $quotation->company ?? '' }}
            </p>
        </div>

        <!-- Separator -->
        <div class="border-t border-gray-200 my-4"></div>

        <!-- Details Section -->
        <div class="space-y-2 mb-6">
            <div class="flex justify-between text-sm">
                <span class="text-gray-500">Date:</span>
                <span class="text-gray-700 font-medium">{{ $quotation->created_at->format('Y-m-d') }}</span>
            </div>

            <div class="flex justify-between text-sm">
                <span class="text-gray-500">Items:</span>
                <span class="text-gray-700 font-medium">{{ optional($quotation->items)->count() ?? 0 }} items</span>
            </div>

            <div class="flex justify-between text-base pt-1">
                <span class="text-gray-700 font-semibold">Total:</span>
                <span class="text-purple-600 font-bold">${{ $quotation->total }}</span>
            </div>
        </div>

        <!-- Separator -->
        <div class="border-t border-gray-200 my-4"></div>

        <!-- Actions -->
        <div class="flex items-center gap-3">

            <!-- View -->
            <a href="{{ route('view', $quotation->id) }}"
               class="flex-1 flex items-center justify-center space-x-2 px-4 py-2 bg-white text-gray-700 border border-gray-300 rounded-lg shadow-sm hover:bg-gray-50 transition">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                     viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                     class="text-blue-600">
                    <path d="M2.062 12C3.085 7.944 7.058 5 12 5s8.916 2.944 9.938 7c-1.022 4.056-4.996 7-9.938 7S3.085 16.056 2.062 12z"/>
                    <circle cx="12" cy="12" r="3"/>
                </svg>
                <span class="font-medium">View</span>
            </a>

            <!-- Edit -->
            <a href="{{ route('editquotation', $quotation->id) }}"
               class="flex-1 flex items-center justify-center space-x-2 px-4 py-2 bg-white text-gray-700 border border-gray-300 rounded-lg shadow-sm hover:bg-gray-50 transition">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                     viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                     class="text-yellow-500">
                    <path d="m18 2 4 4-12 12H6v-4L18 2z"/>
                    <path d="m15 5 4 4"/>
                </svg>
                <span class="font-medium">Edit</span>
            </a>

            <!-- Right Side Buttons -->
            <div class="flex gap-2">

                <!-- Copy Button -->
                <a href="{{ route('quotations.copy', $quotation->id) }}"
   class="p-2 bg-white text-green-500 border border-green-300 rounded-lg hover:bg-green-50 shadow-sm transition flex items-center justify-center">
    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
         viewBox="0 0 24 24" fill="none"
         stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
         class="text-green-600">
        <rect x="9" y="9" width="13" height="13" rx="2" ry="2"></rect>
        <rect x="3" y="3" width="13" height="13" rx="2" ry="2"></rect>
    </svg>
    <span class="ml-1 font-medium">Copy</span>
</a>

                <!-- Delete -->
                <form action="{{ route('quotations.delete', $quotation->id) }}" method="POST"
                      onsubmit="return confirm('Are you sure?');">
                    @csrf
                    @method('DELETE')

                    <button type="submit"
                            class="p-2 bg-white text-red-500 border border-red-300 rounded-lg hover:bg-red-50 hover:text-red-600 shadow-sm transition">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                             viewBox="0 0 24 24" fill="none"
                             stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                             class="text-red-600">
                            <path d="M3 6h18"/>
                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"/>
                            <path d="M10 11v6"/>
                            <path d="M14 11v6"/>
                            <path d="M9 6V4h6v2"/>
                        </svg>
                    </button>
                </form>

            </div>
        </div>

    </div>

    @empty
        <p class="text-gray-500 col-span-3 text-center py-10">No quotations found.</p>
    @endforelse
</div>

        <div class="mt-6">
            {{ $quotations->withQueryString()->links() }}
        </div>

    </main>
</div>

</body>
</html>
