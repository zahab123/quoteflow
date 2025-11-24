<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex flex-col lg:flex-row bg-gray-100">

<div class="absolute top-4 left-4 flex items-center gap-2">
    <img src="{{ asset('images/Capture.PNG') }}" alt="Logo" class="w-10 h-10 object-contain">
    <span class="text-white font-bold text-xl">QuoteFlow</span>
</div>

<div class="hidden lg:flex w-full lg:w-1/2 bg-gradient-to-br from-purple-600 to-blue-500 text-white flex-col justify-center p-16">
    <h1 class="text-5xl font-extrabold mb-6 leading-snug">
        Create, Send & <br> Track Your Proposals
    </h1>
    <p class="text-lg opacity-90 mb-12">
        Professional quotations and proposals in minutes. Perfect for freelancers, agencies, and small businesses.
    </p>

    <div class="flex gap-10 text-center mt-6">
        <div>
            <p class="text-3xl font-bold">1000+</p>
            <p class="text-sm opacity-85">Active Users</p>
        </div>
        <div>
            <p class="text-3xl font-bold">50K+</p>
            <p class="text-sm opacity-85">Quotations Sent</p>
        </div>
        <div>
            <p class="text-3xl font-bold">95%</p>
            <p class="text-sm opacity-85">Success Rate</p>
        </div>
    </div>
</div>

    <div class="w-full lg:w-1/2 flex items-center justify-center p-6 lg:p-16">
        <div class="w-full max-w-md bg-white shadow-xl rounded-2xl p-8 lg:p-12">
            
            <h1 class="text-3xl font-bold text-center text-purple-600 mb-2 lg:mb-4">Welcome Back</h1>
            <p class="text-gray-500 text-center mb-8">
                Sign in to your account to continue
            </p>
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-4">
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition duration-200" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>
                <div class="mb-4">
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input id="password" class="block mt-1 w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition duration-200" type="password" name="password" required autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>
                <div class="mb-4">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                        <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                    </label>
                </div>
                <div class="flex items-center justify-between mt-6">
                    @if (Route::has('password.request'))
                        <a class="text-sm text-purple-600 hover:text-purple-800 transition duration-200" href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif

                    <x-primary-button class="bg-gradient-to-r from-purple-600 to-blue-500 hover:opacity-90 text-white font-semibold py-2 px-6 rounded-lg transition duration-200">
                        {{ __('Log in') }}
                    </x-primary-button>
                </div>

                <p class="text-center text-gray-500 mt-6">
                    Don't have an account?
                    <a href="{{ route('register') }}" class="text-purple-600 font-semibold hover:text-purple-800 transition duration-200">Create one now</a>
                </p>
            </form>

        </div>
    </div>

</body>
</html>
