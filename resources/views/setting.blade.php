<!DOCTYPE html>
<html lang="en" x-data="{ darkMode: false }" :class="{ 'dark': darkMode }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings - QuoteFlow</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script>
        tailwind.config = {
            darkMode: 'class'
        }
    </script>
</head>
<body class="h-full flex bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-200">

    <!-- Sidebar -->
    <aside class="w-60 bg-white dark:bg-gray-800 h-full shadow-md border-r flex flex-col justify-between">
        <!-- Logo -->
        <div class="px-6 py-6 flex items-center gap-2 border-b dark:border-gray-700">
            <div class="w-10 h-10 bg-purple-600 rounded-full flex items-center justify-center text-white font-bold text-lg">QF</div>
            <span class="text-purple-600 font-bold text-xl">QuoteFlow</span>
        </div>

        <!-- Navigation -->
        <ul class="mt-4 flex-1 font-medium">
            <li>
                <a href="/admin/dashboard"
                   class="flex items-center px-6 py-3 rounded-lg transition
                        {{ request()->is('admin/dashboard') ? 'bg-gradient-to-r from-purple-600 to-pink-500 text-white shadow' : 'hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                    <x-heroicon-o-home class="w-5 h-5 mr-3" />
                    Dashboard
                </a>
            </li>
            <li>
                <a href="/clientlist"
                   class="flex items-center px-6 py-3 rounded-lg transition
                        {{ request()->is('clientlist') ? 'bg-gradient-to-r from-purple-600 to-pink-500 text-white shadow' : 'hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                    <x-heroicon-o-users class="w-5 h-5 mr-3" />
                    Clients
                </a>
            </li>
            <li>
                <a href="{{ route('quotationlist') }}"
                   class="flex items-center px-6 py-3 rounded-lg transition
                        {{ request()->is('quotationlist') ? 'bg-gradient-to-r from-purple-600 to-pink-500 text-white shadow' : 'hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                    <x-heroicon-o-document-text class="w-5 h-5 mr-3" />
                    Quotations
                </a>
            </li>
            <li>
                <a href="/report"
                   class="flex items-center px-6 py-3 rounded-lg transition
                        {{ request()->is('reports') ? 'bg-gradient-to-r from-purple-600 to-pink-500 text-white shadow' : 'hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                    <x-heroicon-o-chart-bar class="w-5 h-5 mr-3" />
                    Reports
                </a>
            </li>
            <li>
                <a href="/setting"
                   class="flex items-center px-6 py-3 rounded-lg transition
                        {{ request()->is('settings') ? 'bg-gradient-to-r from-purple-600 to-pink-500 text-white shadow' : 'hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                    <x-heroicon-o-cog class="w-5 h-5 mr-3" />
                    Settings
                </a>
            </li>
        </ul>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 p-6 overflow-auto">
        <h1 class="text-2xl font-bold mb-6">Settings</h1>

        <!-- Company Information -->
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6 mb-6">
            <h2 class="text-lg font-semibold mb-4">Company Information</h2>
            <form class="space-y-4">
                <div>
                    <label class="block mb-1">Company Name</label>
                    <input type="text" placeholder="Your Company Name" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500">
                </div>
                <div>
                    <label class="block mb-1">Email</label>
                    <input type="email" placeholder="company@example.com" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500">
                </div>
                <div>
                    <label class="block mb-1">Phone</label>
                    <input type="text" placeholder="+1 234 567 890" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500">
                </div>
                <div>
                    <label class="block mb-1">Address</label>
                    <textarea placeholder="Company Address" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500"></textarea>
                </div>
                <button type="submit" class="px-6 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-lg font-semibold">Save Changes</button>
            </form>
        </div>

        <!-- Theme Settings -->
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <h2 class="text-lg font-semibold mb-4">Theme Settings</h2>
            <div class="flex items-center justify-between">
                <span>Dark Mode</span>
                <button @click="darkMode = !darkMode"
                        class="px-4 py-2 rounded-lg font-semibold text-white"
                        :class="darkMode ? 'bg-purple-600 hover:bg-purple-700' : 'bg-gray-700 hover:bg-gray-800'">
                    <span x-text="darkMode ? 'Enabled' : 'Disabled'"></span>
                </button>
            </div>
        </div>
    </div>

</body>
</html>
