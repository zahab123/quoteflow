<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quotations - QuoteFlow</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body class="h-screen flex bg-gray-100">

    <!-- Sidebar -->
    <aside class="w-60 bg-white h-full shadow-md border-r flex flex-col justify-between">
        <div class="px-6 py-6 flex items-center gap-2 border-b">
            <div class="w-10 h-10 bg-purple-600 rounded-full flex items-center justify-center text-white font-bold text-lg">QF</div>
            <span class="text-purple-600 font-bold text-xl">QuoteFlow</span>
        </div>
        <ul class="mt-4 space-y-1 text-gray-700 font-medium flex-1">
            <li><a href="/admin/dashboard" class="block px-6 py-2 hover:bg-gray-100 rounded">Dashboard</a></li>
            <li><a href="/clientlist" class="block px-6 py-2 hover:bg-gray-100 rounded">Clients</a></li>
            <li><a href="{{ route('quotationlist') }}" class="block px-6 py-2 hover:bg-gray-100 rounded bg-gray-200">Quotations</a></li>
            <li><a href="/reports" class="block px-6 py-2 hover:bg-gray-100 rounded">Reports</a></li>
            <li><a href="/settings" class="block px-6 py-2 hover:bg-gray-100 rounded">Settings</a></li>
        </ul>
        <div class="px-6 py-6 flex items-center gap-3 border-t relative" x-data="{ open: false }">
            <button @click="open = !open"
                    class="w-12 h-12 rounded-full flex items-center justify-center text-white text-lg font-bold"
                    style="background: linear-gradient(135deg, #6366F1, #EC4899);">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </button>
            <div class="hidden md:block">
                <div class="font-medium text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>
            <div x-show="open" x-cloak @click.away="open = false"
                 class="absolute bottom-20 left-16 w-48 bg-white border rounded shadow-lg z-50">
                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Profile</a>
                <a href="{{ route('logout') }}" class="block px-4 py-2 text-gray-800 hover:bg-gray-100"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
            </div>
        </div>
    </aside>

    <!-- Main content -->
    <div class="flex-1 flex flex-col h-full overflow-hidden">
        <nav class="bg-white border-b border-gray-100 flex-shrink-0">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16 items-center">
                    <div class="flex items-center space-x-4">
                        <button onclick="document.documentElement.classList.toggle('dark')" class="p-2 rounded-full hover:bg-gray-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 3v1m0 16v1m8.485-8.485l-.707.707M4.222 4.222l-.707.707M21 12h-1M4 12H3m16.485 4.485l-.707-.707M4.222 19.778l-.707-.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </nav>

        <main class="flex-1 p-10 overflow-auto">
            <div class="mb-6 flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Quotations</h1>
                    <p class="text-sm text-gray-500">Manage all your quotations</p>
                </div>
                <a href="{{ route('quotations') }}" class="px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition">
                    + New Quotation
                </a>
            </div>

            <div class="mb-6">
                <input type="text" placeholder="Search quotations..." class="w-full md:w-1/3 px-4 py-2 rounded-lg border focus:outline-none focus:ring-2 focus:ring-purple-500" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($quotations as $quotation)
                    <div class="bg-white rounded-xl shadow p-6 flex flex-col justify-between">
                        <div class="mb-4">
                            <div class="flex justify-between items-center mb-2">
                                <h2 class="font-bold text-lg text-gray-800">Quotation #{{ $quotation->id }}</h2>
                                <span class="text-sm font-medium px-2 py-1 rounded-full
                                    @if($quotation->status == 'Approved') bg-green-100 text-green-600
                                    @elseif($quotation->status == 'Pending') bg-yellow-100 text-yellow-700
                                    @else bg-gray-100 text-gray-600 @endif">
                                    {{ $quotation->status }}
                                </span>
                            </div>
                            <p class="text-gray-600"><span class="font-semibold">Client:</span> {{ $quotation->client->name ?? 'N/A' }}</p>
                            <p class="text-gray-600"><span class="font-semibold">Date:</span> {{ $quotation->created_at->format('Y-m-d') }}</p>
                            <p class="text-gray-600"><span class="font-semibold">Items:</span> {{ $quotation->items->count() }}</p>
                            <p class="text-gray-600"><span class="font-semibold">Total Amount:</span> ${{ $quotation->total }}</p>
                        </div>
                        <div class="mt-4 flex space-x-2">
                            <a href="{{ route('quotations.show', $quotation->id) }}" class="flex items-center px-3 py-2 bg-blue-100 text-blue-600 rounded hover:bg-blue-200 transition">View</a>
                            <a href="{{ route('quotations.edit', $quotation->id) }}" class="flex items-center px-3 py-2 bg-green-100 text-green-600 rounded hover:bg-green-200 transition">Edit</a>
                            <form action="{{ route('quotations.destroy', $quotation->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="flex items-center px-3 py-2 bg-red-100 text-red-600 rounded hover:bg-red-200 transition">Delete</button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500 col-span-3">No quotations found.</p>
                @endforelse
            </div>
        </main>
    </div>
</body>
</html>
