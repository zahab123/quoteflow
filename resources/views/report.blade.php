<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - QuoteFlow</title>
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
                <a href="/admin/dashboard" class="flex items-center px-6 py-3 transition rounded-lg
                    {{ request()->is('admin/dashboard') ? 'bg-gradient-to-r from-purple-600 to-pink-500 text-white shadow' : 'hover:bg-gray-100 text-gray-700' }}">
                    <x-heroicon-o-home class="w-5 h-5 mr-3" />
                    Dashboard
                </a>
            </li>
            <li>
                <a href="/clientlist" class="flex items-center px-6 py-3 transition rounded-lg
                    {{ request()->is('clientlist') ? 'bg-gradient-to-r from-purple-600 to-pink-500 text-white shadow' : 'hover:bg-gray-100 text-gray-700' }}">
                    <x-heroicon-o-users class="w-5 h-5 mr-3" />
                    Clients
                </a>
            </li>
            <li>
                <a href="{{ route('quotationlist') }}" class="flex items-center px-6 py-3 transition rounded-lg
                    {{ request()->is('quotationlist') ? 'bg-gradient-to-r from-purple-600 to-pink-500 text-white shadow' : 'hover:bg-gray-100 text-gray-700' }}">
                    <x-heroicon-o-document-text class="w-5 h-5 mr-3" />
                    Quotations
                </a>
            </li>
            <li>
                <a href="/report" class="flex items-center px-6 py-3 transition rounded-lg
                    {{ request()->is('reports') ? 'bg-gradient-to-r from-purple-600 to-pink-500 text-white shadow' : 'hover:bg-gray-100 text-gray-700' }}">
                    <x-heroicon-o-chart-bar class="w-5 h-5 mr-3" />
                    Reports
                </a>
            </li>
            <li>
                <a href="/setting" class="flex items-center px-6 py-3 transition rounded-lg
                    {{ request()->is('settings') ? 'bg-gradient-to-r from-purple-600 to-pink-500 text-white shadow' : 'hover:bg-gray-100 text-gray-700' }}">
                    <x-heroicon-o-cog class="w-5 h-5 mr-3" />
                    Settings
                </a>
            </li>
        </ul>

        <!-- User Profile -->
        <div class="px-6 py-6 flex items-center gap-3 border-t" x-data="{ open: false }">
            <button @click="open = !open" class="w-12 h-12 rounded-full flex items-center justify-center text-white text-lg font-bold"
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

        <!-- Top Navigation -->
        <nav class="bg-white border-b border-gray-200 shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16 items-center">
                    <h1 class="text-xl font-semibold text-gray-800">Report And Analysis</h1>
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
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                <!-- Quotations Per Month -->
                <div class="bg-white shadow-md rounded-lg p-5">
                    <h2 class="text-gray-600 font-semibold mb-3">Quotations Per Month</h2>
                    <canvas id="barChart" class="w-full h-64"></canvas>
                </div>

                <!-- Quotation Status -->
                <div class="bg-white shadow-md rounded-lg p-5 flex flex-col items-center">
                    <h2 class="text-gray-600 font-semibold mb-3">Quotation Status</h2>
                    <div class="w-48 h-48">
                        <canvas id="doughnutChart" class="w-full h-full"></canvas>
                    </div>
                </div>

                <!-- Revenue Trend -->
                <div class="bg-white shadow-md rounded-lg p-5">
                    <h2 class="text-gray-600 font-semibold mb-3">Revenue Trend</h2>
                    <canvas id="revenueChart" class="w-full h-64"></canvas>
                </div>
            </div>

        </main>
    </div>

<script>
    // Bar Chart - Quotations Per Month
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

    // Doughnut Chart - Status
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

    // Line Chart - Revenue Trend
    const ctxRevenue = document.getElementById('revenueChart').getContext('2d');
    new Chart(ctxRevenue, {
        type: 'line',
        data: {
            labels: {!! json_encode($monthlyLabels ?? []) !!},
            datasets: [{
                label: 'Revenue ($)',
                data: {!! json_encode($monthlyRevenue ?? []) !!},
                fill: true,
                backgroundColor: 'rgba(99, 102, 241, 0.2)',
                borderColor: '#6366F1',
                tension: 0.3,
                pointBackgroundColor: '#6366F1',
                pointBorderColor: '#6366F1',
                pointRadius: 4
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) { return '$' + value; }
                    }
                }
            },
            plugins: { legend: { display: true, position: 'top' } }
        }
    });
</script>

</body>
</html>
