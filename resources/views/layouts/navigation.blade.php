<!DOCTYPE html>
<html lang="en" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen">

    <!-- Navbar -->
    <nav class="bg-white shadow-lg rounded-b-xl">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-blue-600">User Dashboard</h1>
            <div class="flex items-center space-x-6">
                <span class="text-gray-800 text-base">{{ Auth::user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-red-500 hover:underline">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="max-w-4xl mx-auto mt-12 bg-white shadow-md rounded-2xl p-8">
        <h2 class="text-3xl font-semibold text-gray-900">👋 Welcome, {{ Auth::user()->name }}!</h2>
        <p class="mt-2 text-gray-600 text-lg">
            You are logged in with the email: <span class="font-medium">{{ Auth::user()->email }}</span>.
        </p>

        <div class="mt-8">
            <a href="/profile"
                class="inline-block px-6 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-all">
                Edit Profile
            </a>
        </div>
    </main>

</body>

</html>