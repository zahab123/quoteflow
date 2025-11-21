<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>

    <!-- ⭐ Add ID + dark classes here -->
    <body id="mainBody" class="font-sans antialiased bg-gray-100 text-gray-900 dark:bg-gray-900 dark:text-white transition-colors duration-300">

        <div class="min-h-screen">
            
            @include('layouts.navigation')

            <!-- ⭐ Add toggle button anywhere (Navbar is ideal) -->
            <div class="px-4 py-2">
                <button id="themeToggle" class="p-2 rounded bg-gray-200 dark:bg-gray-700 dark:text-white">
                    🌙 / ☀️
                </button>
            </div>

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>

        <!-- ⭐ Add JavaScript for Dark Mode -->
        <script>
            const body = document.getElementById("mainBody");
            const btn = document.getElementById("themeToggle");

            // Apply saved theme on all pages
            if (localStorage.getItem("theme") === "dark") {
                body.classList.add("dark");
            }

            // Toggle
            btn.addEventListener("click", () => {
                body.classList.toggle("dark");

                if (body.classList.contains("dark")) {
                    localStorage.setItem("theme", "dark");
                } else {
                    localStorage.setItem("theme", "light");
                }
            });
        </script>

    </body>
</html>
