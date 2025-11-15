<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Add Client - QuoteFlow</title>
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body class="h-full bg-gray-100 flex">

    <!-- Sidebar -->
    <aside class="w-60 bg-white h-full shadow-md border-r flex flex-col justify-between">
        <div class="px-6 py-6 flex items-center gap-2 border-b">
            <div class="w-10 h-10 bg-purple-600 rounded-full flex items-center justify-center text-white font-bold text-lg">QF</div>
            <span class="text-purple-600 font-bold text-xl">QuoteFlow</span>
        </div>
        <ul class="mt-4 space-y-1 text-gray-700 font-medium flex-1">
            <li><a href="/admin/dashboard" class="block px-6 py-2 hover:bg-gray-100 rounded">Dashboard</a></li>
            <li><a href="/clientlist" class="block px-6 py-2 hover:bg-gray-100 rounded bg-gray-200">Clients</a></li>
            <li><a href="/quotationlist" class="block px-6 py-2 hover:bg-gray-100 rounded">Quotations</a></li>
            <li><a href="/reports" class="block px-6 py-2 hover:bg-gray-100 rounded">Reports</a></li>
            <li><a href="/settings" class="block px-6 py-2 hover:bg-gray-100 rounded">Settings</a></li>
        </ul>

        <div class="px-6 py-6 flex items-center gap-3 border-t" x-data="{ open: false }">
            <button @click="open = !open" class="w-12 h-12 rounded-full flex items-center justify-center text-white text-lg font-bold" style="background: linear-gradient(135deg, #6366F1, #EC4899);">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </button>
            <div>
                <div class="font-medium text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>
            <div x-show="open" @click.away="open = false" class="absolute bottom-20 left-16 w-48 bg-white border rounded shadow-lg z-50">
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

    <!-- Main Content -->
    <div class="flex-1 flex flex-col">
        <nav class="bg-white border-b border-gray-100">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16 items-center">
                    <div class="flex items-center space-x-4"></div>
                    <div class="flex items-center space-x-4">
                        <button class="relative p-2 rounded-full hover:bg-gray-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405C18.21 15.21 18 14.11 18 13V9a6 6 0 10-12 0v4c0 1.11-.21 2.21-.595 3.595L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                            <span class="absolute top-0 right-0 w-2 h-2 bg-red-500 rounded-full"></span>
                        </button>
                        <button onclick="document.documentElement.classList.toggle('dark')" class="p-2 rounded-full hover:bg-gray-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                    d="M12 3v1m0 16v1m8.485-8.485l-.707.707M4.222 4.222l-.707.707M21 12h-1M4 12H3m16.485 4.485l-.707-.707M4.222 19.778l-.707-.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </button>
                        <div x-data="{ open: false }" class="relative">
                            <button @click="open = !open" class="w-10 h-10 rounded-full flex items-center justify-center text-white text-lg font-bold" style="background: linear-gradient(135deg, #6366F1, #EC4899);">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </button>
                            <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white border rounded shadow-lg z-50">
                                <x-dropdown-link :href="route('profile.edit')" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Profile</x-dropdown-link>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Log Out</x-dropdown-link>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
        <main class="flex-1 p-6 md:p-10 overflow-auto">
            <h1 class="text-2xl font-bold text-gray-800 mb-2">Add New Client</h1>
            <p class="text-gray-500 mb-6">Create and manage client profiles</p>

            <div class="bg-white p-6 md:p-8 rounded-xl shadow overflow-auto">
                <form action="{{ route('addclient') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="text-gray-700 font-medium">Client Name *</label>
                        <input type="text" name="name" class="w-full border rounded-lg p-2 mt-1" placeholder="Enter client name" required>
                    </div>
                    <div class="mb-4">
                        <label class="text-gray-700 font-medium">Company</label>
                        <input type="text" name="company" class="w-full border rounded-lg p-2 mt-1" placeholder="Company name">
                    </div>
                    <div class="mb-4">
                        <label class="text-gray-700 font-medium">Email *</label>
                        <input type="email" name="email" class="w-full border rounded-lg p-2 mt-1" placeholder="Client email" required>
                    </div>
                    <div class="mb-4">
                        <label class="text-gray-700 font-medium">Phone</label>
                        <input type="text" name="phone" class="w-full border rounded-lg p-2 mt-1" placeholder="Client phone number">
                    </div>
                    <div class="mb-4">
                        <label class="text-gray-700 font-medium">Address</label>
                        <textarea name="address" rows="3" class="w-full border rounded-lg p-2 mt-1" placeholder="Client address"></textarea>
                    </div>
                    <div class="mb-4">
                        <label class="text-gray-700 font-medium">Notes (Optional)</label>
                        <textarea name="notes" rows="3" class="w-full border rounded-lg p-2 mt-1" placeholder="Any additional notes"></textarea>
                    </div>

                    <div class="flex flex-col md:flex-row gap-4">
                        <button type="submit" class="bg-purple-600 text-white px-5 py-2 rounded-lg w-full md:w-auto">Save Client</button>
                        <a href="/clientlist" class="px-5 py-2 border rounded-lg w-full md:w-auto text-center hover:bg-gray-100">Client List</a>
                    </div>
                </form>
            </div>
        </main>
    </div>

</body>
</html>
