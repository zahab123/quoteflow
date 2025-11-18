<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clients List</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body class="h-full bg-gray-100 flex flex-col md:flex-row" x-data="clientsData()">

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

                    <!-- Dark/Light Mode (Remove toggle for light mode only view) -->
                    <button class="p-2 rounded-full hover:bg-gray-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 3v1m0 16v1m8.485-8.485l-.707.707M4.222 4.222l-.707.707M21 12h-1M4 
                                12H3m16.485 4.485l-.707-.707M4.222 19.778l-.707-.707M16 
                                12a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </button>

                    <!-- Profile -->
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

        <main class="flex-1 px-6 md:px-10 py-8 overflow-auto">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Clients Management</h1>
                    <p class="text-gray-500">Manage all client records</p>
                </div>
                <a href="/client" class="bg-purple-600 text-white px-4 py-2 rounded-lg shadow">
                   + Add Client
                </a>
            </div>

            <div class="mb-4">
                <input type="text" x-model="search" placeholder="Search clients..." 
                       class="w-full md:w-1/3 px-4 py-2 border rounded-lg shadow-sm focus:outline-none focus:ring focus:border-purple-300">
            </div>

            <div class="bg-white rounded-xl shadow overflow-x-auto">
                <table class="w-full text-sm text-left border-collapse">
                    <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="p-3 border">ID</th>
                        <th class="p-3 border">Name</th>
                        <th class="p-3 border">Company</th>
                        <th class="p-3 border">Email</th>
                        <th class="p-3 border">Phone</th>
                        <th class="p-3 border">Address</th>
                        <th class="p-3 border">Notes</th>
                        <th class="p-3 border text-center">Action</th>
                    </tr>
                    </thead>

                    <tbody>
                    <template x-for="client in filteredClients()" :key="client.id">
                        <tr class="hover:bg-gray-50">
                            <td class="p-3 border" x-text="client.id"></td>
                            <td class="p-3 border" x-text="client.name"></td>
                            <td class="p-3 border" x-text="client.company"></td>
                            <td class="p-3 border" x-text="client.email"></td>
                            <td class="p-3 border" x-text="client.phone"></td>
                            <td class="p-3 border" x-text="client.address"></td>
                            <td class="p-3 border" x-text="client.notes"></td>
                            <td class="p-3 border text-center flex justify-center gap-2">
                                <a :href="`/updateclient/${client.id}`" class="text-blue-500 hover:text-blue-700">
                                    ✏️
                                </a>
                                <a :href="`/deleteclient/${client.id}`" class="text-red-500 hover:text-red-700">
                                    🗑️
                                </a>
                            </td>
                        </tr>
                    </template>
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <script>
        function clientsData() {
            return {
                search: '',
                clients: @json($clients),
                filteredClients() {
                    if (!this.search) return this.clients;
                    return this.clients.filter(c => 
                        c.name.toLowerCase().includes(this.search.toLowerCase()) ||
                        c.company.toLowerCase().includes(this.search.toLowerCase()) ||
                        c.email.toLowerCase().includes(this.search.toLowerCase()) ||
                        c.phone.toLowerCase().includes(this.search.toLowerCase())
                    );
                }
            }
        }
    </script>
</body>
</html>
