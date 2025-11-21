<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QuoteFlow Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <style>
    .card-shadow {
        box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05), 0 2px 4px -2px rgba(0,0,0,0.05);
    }
    .card-shadow:hover {
        box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1), 0 4px 6px -4px rgba(0,0,0,0.1);
    }
    </style>

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
                            <h1 class="text-xl font-semibold text-gray-800 **hidden sm:block**">Dashboard</h1>
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
<button id="themeToggle" class="p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700 hidden sm:block">
    <!-- Light Mode Icon (Sun) -->
    <svg id="sunIcon" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600 dark:hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M12 3v1m0 16v1m8.485-8.485l-.707.707M4.222 4.222l-.707.707M21 12h-1M4 
                 12H3m16.485 4.485l-.707-.707M4.222 19.778l-.707-.707M16 
                 12a4 4 0 11-8 0 4 4 0 018 0z" />
    </svg>

    <!-- Dark Mode Icon (Moon) -->
    <svg id="moonIcon" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-400 hidden dark:block" fill="currentColor" viewBox="0 0 24 24">
        <path d="M21 12.79A9 9 0 1111.21 3a7 7 0 109.79 9.79z"/>
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
        <main class="flex-1 p-6 bg-gray-100 overflow-auto">
            <div class="mb-8">
                  <h1 class="text-3xl font-bold text-gray-800">Dashboard</h1>
                  <p class="text-gray-600 mt-2">Welcome back! Here's what's happening with your quotations.</p>
            </div>
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">

    <!-- CARD 1: Total Quotations -->
    <div class="bg-white p-6 rounded-xl shadow-md transition duration-300 hover:bg-gray-50">
        <div class="flex items-start justify-between">
            <p class="text-sm font-medium text-gray-500">Total Quotations</p>
            <div class="w-10 h-10 flex items-center justify-center rounded-xl text-white bg-gradient-to-br from-blue-500 to-blue-600 shadow-lg shadow-blue-500/50">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                    <polyline points="14 2 14 8 20 8"></polyline>
                    <line x1="16" y1="13" x2="8" y2="13"></line>
                    <line x1="16" y1="17" x2="8" y2="17"></line>
                    <polyline points="10 9 12 11 14 9"></polyline>
                </svg>
            </div>
        </div>
        <div class="mt-4">
            <p class="text-4xl font-semibold text-gray-900">{{ $totalQuotations ?? 0 }}</p>
        </div>
        <div class="mt-4 flex items-center text-sm font-medium">
            @php
                $prevTotal = \App\Models\Quotations::whereMonth('created_at', now()->subMonth()->month)->count();
                $totalPercent = $prevTotal ? round((($totalQuotations - $prevTotal)/$prevTotal)*100) : 0;
                $totalColor = $totalPercent >= 0 ? 'text-green-500' : 'text-red-500';
            @endphp
            <svg class="w-4 h-4 {{ $totalColor }} mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8m-6 4H4a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v2"></path>
            </svg>
            <span class="{{ $totalColor }}">{{ $totalPercent }}%</span>
            <span class="text-gray-500 ml-1">from last month</span>
        </div>
    </div>

    <!-- CARD 2: Accepted -->
    <div class="bg-white p-6 rounded-xl shadow-md transition duration-300 hover:bg-gray-50">
        <div class="flex items-start justify-between">
            <p class="text-sm font-medium text-gray-500">Accepted</p>
            <div class="w-10 h-10 flex items-center justify-center rounded-xl text-white bg-gradient-to-br from-green-500 to-green-600 shadow-lg shadow-green-500/50">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="20 6 9 17 4 12"></polyline>
                </svg>
            </div>
        </div>
        <div class="mt-4">
            <p class="text-4xl font-semibold text-gray-900">{{ $acceptedQuotations ?? 0 }}</p>
        </div>
        <div class="mt-4 flex items-center text-sm font-medium">
            @php
                $prevAccepted = \App\Models\Quotations::where('status','accepted')->whereMonth('created_at', now()->subMonth()->month)->count();
                $acceptedPercent = $prevAccepted ? round((($acceptedQuotations - $prevAccepted)/$prevAccepted)*100) : 0;
                $acceptedColor = $acceptedPercent >= 0 ? 'text-green-500' : 'text-red-500';
            @endphp
            <svg class="w-4 h-4 {{ $acceptedColor }} mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8m-6 4H4a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v2"></path>
            </svg>
            <span class="{{ $acceptedColor }}">{{ $acceptedPercent }}%</span>
            <span class="text-gray-500 ml-1">from last month</span>
        </div>
    </div>

    <!-- CARD 3: Pending -->
    <div class="bg-white p-6 rounded-xl shadow-md transition duration-300 hover:bg-gray-50">
        <div class="flex items-start justify-between">
            <p class="text-sm font-medium text-gray-500">Pending</p>
            <div class="w-10 h-10 flex items-center justify-center rounded-xl text-white bg-gradient-to-br from-orange-500 to-orange-600 shadow-lg shadow-orange-500/50">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <polyline points="12 6 12 12 16 14"></polyline>
                </svg>
            </div>
        </div>
        <div class="mt-4">
            <p class="text-4xl font-semibold text-gray-900">{{ $pendingQuotations ?? 0 }}</p>
        </div>
        <div class="mt-4 flex items-center text-sm font-medium">
            @php
                $prevPending = \App\Models\Quotations::where('status','sent')->whereMonth('created_at', now()->subMonth()->month)->count();
                $pendingPercent = $prevPending ? round((($pendingQuotations - $prevPending)/$prevPending)*100) : 0;
                $pendingColor = $pendingPercent >= 0 ? 'text-green-500' : 'text-red-500';
            @endphp
            <svg class="w-4 h-4 {{ $pendingColor }} mr-1 transform rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8m-6 4H4a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v2"></path>
            </svg>
            <span class="{{ $pendingColor }}">{{ $pendingPercent }}%</span>
            <span class="text-gray-500 ml-1">from last month</span>
        </div>
    </div>

    <!-- CARD 4: Total Revenue -->
    <div class="bg-white p-6 rounded-xl shadow-md transition duration-300 hover:bg-gray-50">
        <div class="flex items-start justify-between">
            <p class="text-sm font-medium text-gray-500">Total Revenue</p>
            <div class="w-10 h-10 flex items-center justify-center rounded-xl text-white bg-gradient-to-br from-purple-500 to-purple-600 shadow-lg shadow-purple-500/50">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="12" y1="1" x2="12" y2="23"></line>
                    <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                </svg>
            </div>
        </div>
        <div class="mt-4">
            <p class="text-4xl font-semibold text-gray-900">${{ number_format($totalRevenue ?? 0, 2) }}</p>
        </div>
        <div class="mt-4 flex items-center text-sm font-medium">
            @php
                $prevRevenue = \App\Models\Quotations::where('status','accepted')->whereMonth('created_at', now()->subMonth()->month)->sum('total');
                $revenuePercent = $prevRevenue ? round((($totalRevenue - $prevRevenue)/$prevRevenue)*100) : 0;
                $revenueColor = $revenuePercent >= 0 ? 'text-green-500' : 'text-red-500';
            @endphp
            <svg class="w-4 h-4 {{ $revenueColor }} mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8m-6 4H4a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v2"></path>
            </svg>
            <span class="{{ $revenueColor }}">{{ $revenuePercent }}%</span>
            <span class="text-gray-500 ml-1">from last month</span>
        </div>
    </div>

</div>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                <div class="bg-white shadow-md rounded-lg p-5">
                    <h2 class="text-gray-600 font-semibold mb-3">Quotations Per Month</h2>
                    <canvas id="barChart" class="w-full h-64"></canvas>
                </div>
                <div class="bg-white shadow-md rounded-lg p-5 flex flex-col items-center">
                    <h2 class="text-gray-600 font-semibold mb-3">Quotation Status</h2>
                    <div class="w-48 h-48">
                        <canvas id="doughnutChart" class="w-full h-full"></canvas>
                    </div>
                </div>
            </div>
            <div class="bg-white shadow-md rounded-lg p-5">
                <h2 class="text-gray-600 font-semibold mb-4">Latest Quotations</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase">Title</th>
                                <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase">Client</th>
                                <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase">Created At</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($latestQuotations as $quotation)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $quotation->title }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $quotation->client->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ ucfirst($quotation->status) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $quotation->created_at->format('d M Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </main>
    </div>
</div>
<script>
    const ctxBar = document.getElementById('barChart').getContext('2d');
    new Chart(ctxBar, {
        type: 'bar',
        data: {
            labels: {!! json_encode($monthlyLabels ?? []) !!},
            datasets: [{
                label: 'Quotations',
                data: {!! json_encode($monthlyCounts ?? []) !!},
                backgroundColor: '#6366F1'
            }]
        },
        options: {
            responsive: true,
            scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } },
            plugins: { legend: { display: false } }
        }
    });
    const ctxDoughnut = document.getElementById('doughnutChart').getContext('2d');
    new Chart(ctxDoughnut, {
        type: 'doughnut',
        data: {
            labels: ['Accepted', 'Pending', 'Declined'],
            datasets: [{
                data: [
                    {{ $acceptedQuotations ?? 0 }},
                    {{ $pendingQuotations ?? 0 }},
                    {{ $declinedQuotations ?? 0 }}
                ],
                backgroundColor: ['#10B981', '#F59E0B', '#EF4444'],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { position: 'bottom', labels: { padding: 10, boxWidth: 15 } } },
            cutout: '70%'
        }
    });
</script>

</body>
</html>
