<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Client - QuoteFlow</title>
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
                            <h1 class="text-xl font-semibold text-gray-800 **hidden sm:block**">Create Client</h1>
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

        <main class="flex-1 px-6 md:px-10 py-8 overflow-auto">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Create Client</h1>
                    <p class="text-gray-500">Add a new client record</p>
                </div>
                <a href="/clientlist" class="bg-purple-600 text-white px-4 py-2 rounded-lg shadow">
                   Back to Client List
                </a>
            </div>
            @if(session('success'))
                <div class="mb-4 p-3 rounded-lg bg-green-100 text-green-700 border border-green-300">
                    {{ session('success') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="mb-4 p-3 rounded-lg bg-red-100 text-red-700 border border-red-300">
                    <ul class="list-disc ml-4">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif


            <div class="bg-white p-6 md:p-8 rounded-xl shadow">
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

                    <div class="flex flex-col md:flex-row gap-4 justify-start">
                        <button type="submit" class="bg-purple-600 text-white px-5 py-2 rounded-lg w-full md:w-auto">
                            Save Client
                        </button>
                        <a href="/clientlist" class="px-5 py-2 border rounded-lg w-full md:w-auto text-center hover:bg-gray-100">
                            Client List
                        </a>
                    </div>
                </form>
            </div>
        </main>

    </div>
</div>
</body>
</html>
