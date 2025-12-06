<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Password</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen flex flex-col lg:flex-row bg-gray-100">
    <div
        class="hidden lg:flex w-full lg:w-1/2 bg-gradient-to-br from-purple-600 to-blue-500 text-white flex-col justify-center p-16">
        <h1 class="text-5xl font-extrabold mb-6 leading-snug">
            Confirm Your Password
        </h1>
        <p class="text-lg opacity-90 mb-12">
            This is a secure area of the application. Please confirm your password before continuing.
        </p>
    </div>
    <div class="w-full lg:w-1/2 flex items-center justify-center p-6 lg:p-16">
        <div class="w-full max-w-md bg-white shadow-xl rounded-2xl p-8 lg:p-12">

            <h1 class="text-3xl font-bold text-center text-purple-600 mb-2 lg:mb-4">Confirm Password</h1>
            <p class="text-gray-500 text-center mb-6">
                {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
            </p>
            <form method="POST" action="{{ route('password.confirm') }}">
                @csrf
                <div class="mb-4">
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input id="password"
                        class="block mt-1 w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition duration-200"
                        type="password" name="password" required autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>
                <div class="flex justify-end mt-6">
                    <x-primary-button
                        class="bg-gradient-to-r from-purple-600 to-blue-500 hover:opacity-90 text-white font-semibold py-2 px-6 rounded-lg transition duration-200">
                        {{ __('Confirm') }}
                    </x-primary-button>
                </div>

            </form>

        </div>
    </div>

</body>

</html>