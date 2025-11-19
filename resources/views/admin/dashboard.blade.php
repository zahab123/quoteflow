<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QuoteFlow Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body class="h-full bg-gray-100 flex">

    <!-- Sidebar -->
    <aside class="w-60 bg-white h-full shadow-md border-r flex flex-col justify-between">
        <!-- Logo -->
        <div class="px-6 py-6 flex items-center gap-2 border-b">
            <div class="w-10 h-10 bg-purple-600 rounded-full flex items-center justify-center text-white font-bold text-lg">QF</div>
            <span class="text-purple-600 font-bold text-xl">QuoteFlow</span>
        </div>

        <!-- Navigation -->
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

        <!-- Top Navigation with Search -->
        <nav class="bg-white border-b border-gray-200 shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16 items-center">

                    <!-- Left: Dashboard + Search -->
                    <div class="flex items-center space-x-4">
                        <h1 class="text-xl font-semibold text-gray-800">Dashboard</h1>

                        <!-- Search Bar -->
                        <div class="relative">
                            <input type="text" placeholder="Search..."
                                class="pl-10 pr-4 py-2 rounded-lg border border-gray-300 focus:ring-2 focus:ring-purple-500 focus:border-transparent outline-none w-64">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 1010.5 3a7.5 7.5 0 006.15 13.65z" />
                            </svg>
                        </div>
                    </div>

                    <!-- Right: Notification + Profile -->
                    <div class="flex items-center space-x-6">
                        <!-- Notification -->
                        <button class="relative p-2 rounded-full hover:bg-gray-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 17h5l-1.405-1.405C18.21 15.21 18 14.11 18 13V9a6 6 0 10-12 0v4c0 
                                    1.11-.21 2.21-.595 3.595L4 17h5m6 0v1a3 3 
                                    0 11-6 0v-1m6 0H9" />
                            </svg>
                            <span class="absolute top-0 right-0 w-2 h-2 bg-red-500 rounded-full"></span>
                        </button>

                        <!-- Light/Dark Mode -->
                        <button class="p-2 rounded-full hover:bg-gray-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 3v1m0 16v1m8.485-8.485l-.707.707M4.222 4.222l-.707.707M21 12h-1M4 
                                    12H3m16.485 4.485l-.707-.707M4.222 19.778l-.707-.707M16 
                                    12a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </button>

                        <!-- Profile Dropdown -->
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
            </div>
        </nav>

        <!-- Main Content -->
        <main class="flex-1 p-6 bg-gray-100 overflow-auto">

            <!-- Dashboard Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <div class="bg-gradient-to-r from-purple-600 to-pink-500 text-white shadow-lg rounded-xl p-6 flex flex-col hover:shadow-2xl transition">
                    <span class="uppercase tracking-wide text-sm opacity-80">Total Quotations</span>
                    <span class="text-3xl font-bold mt-2">{{ $totalQuotations ?? 0 }}</span>
                </div>
                <div class="bg-gradient-to-r from-green-500 to-teal-400 text-white shadow-lg rounded-xl p-6 flex flex-col hover:shadow-2xl transition">
                    <span class="uppercase tracking-wide text-sm opacity-80">Accepted Quotations</span>
                    <span class="text-3xl font-bold mt-2">{{ $acceptedQuotations ?? 0 }}</span>
                </div>
                <div class="bg-gradient-to-r from-yellow-400 to-orange-400 text-white shadow-lg rounded-xl p-6 flex flex-col hover:shadow-2xl transition">
                    <span class="uppercase tracking-wide text-sm opacity-80">Pending Quotations</span>
                    <span class="text-3xl font-bold mt-2">{{ $pendingQuotations ?? 0 }}</span>
                </div>
                <div class="bg-gradient-to-r from-blue-500 to-indigo-500 text-white shadow-lg rounded-xl p-6 flex flex-col hover:shadow-2xl transition">
                    <span class="uppercase tracking-wide text-sm opacity-80">Total Revenue</span>
                    <span class="text-3xl font-bold mt-2">${{ number_format($totalRevenue ?? 0, 2) }}</span>
                </div>
            </div>

            <!-- Charts -->
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

            <!-- Latest Quotations Table -->
            <div class="bg-white shadow-md rounded-lg p-5">
                <h2 class="text-gray-600 font-semibold mb-4">Latest Quotations</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 text-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase">Title</th>
                                <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase">Client</th>
                                <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase">Amount</th>
                                <th class="px-6 py-3 text-left font-medium text-gray-500 uppercase">Created At</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($latestQuotations as $quotation)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $quotation->title }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $quotation->client->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ ucfirst($quotation->status) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">${{ number_format($quotation->total_amount, 2) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $quotation->created_at->format('d M Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </main>
    </div>

<script>
    // Bar Chart
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

    // Doughnut Chart
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
