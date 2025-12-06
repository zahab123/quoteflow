<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen flex flex-col lg:flex-row bg-gray-100">

    <div
        class="hidden lg:flex w-full lg:w-1/2 bg-gradient-to-br from-purple-600 to-blue-500 text-white flex-col justify-center p-16">
        <h1 class="text-5xl font-extrabold mb-6 leading-snug">
            Start Building
            Better Proposals
        </h1>
        <p class="text-lg opacity-90 mb-12">
            Join thousands of professionals who trust QuoteFlow
            for their quotation and proposal needs.
        </p>

        <div class="flex gap-10 text-center mt-6">
            <div>
                <p class="text-3xl font-bold">1000+</p>
                <p class="text-sm opacity-85">Active Users</p>
            </div>
            <div>
                <p class="text-3xl font-bold">50K+</p>
                <p class="text-sm opacity-85">Proposals Sent</p>
            </div>
            <div>
                <p class="text-3xl font-bold">95%</p>
                <p class="text-sm opacity-85">Success Rate</p>
            </div>
        </div>
    </div>
    <div class="w-full lg:w-1/2 flex items-center justify-center p-6 lg:p-16">
        <div class="w-full max-w-md bg-white shadow-xl rounded-2xl p-8 lg:p-12">

            <h1 class="text-3xl font-bold text-center text-purple-600 mb-2 lg:mb-4">Create Account</h1>
            <p class="text-gray-500 text-center mb-8">
                Fill in the form to get started
            </p>
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="mb-4">
                    <x-input-label for="name" :value="__('Name')" />
                    <x-text-input id="name"
                        class="block mt-1 w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition duration-200"
                        type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>
                <div class="mb-4">
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email"
                        class="block mt-1 w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition duration-200"
                        type="email" name="email" :value="old('email')" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>
                <div class="mb-4">
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input id="password"
                        class="block mt-1 w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition duration-200"
                        type="password" name="password" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>
                <div class="mb-4">
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                    <x-text-input id="password_confirmation"
                        class="block mt-1 w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition duration-200"
                        type="password" name="password_confirmation" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>
                <div class="flex items-center justify-between mt-6">
                    <a class="text-sm text-purple-600 hover:text-purple-800 transition duration-200 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        href="{{ route('login') }}">
                        {{ __('Already registered?') }}
                    </a>

                    <x-primary-button
                        class="bg-gradient-to-r from-purple-600 to-blue-500 hover:opacity-90 text-white font-semibold py-2 px-6 rounded-lg transition duration-200">
                        {{ __('Register') }}
                    </x-primary-button>
                </div>

            </form>

        </div>
    </div>

</body>

</html>