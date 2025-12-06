<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen flex flex-col lg:flex-row bg-gray-100">
    <div
        class="hidden lg:flex w-full lg:w-1/2 bg-gradient-to-br from-purple-600 to-blue-500 text-white flex-col justify-center p-16">
        <h1 class="text-5xl font-extrabold mb-6 leading-snug">
            Reset Your Password
        </h1>
        <p class="text-lg opacity-90 mb-12">
            Enter your username or email and we will send you a link to reset your password. Stay secure and in control
            of your account.
        </p>
    </div>
    <div class="w-full lg:w-1/2 flex items-center justify-center p-6 lg:p-16">
        <div class="w-full max-w-md bg-white shadow-xl rounded-2xl p-8 lg:p-12">

            <h1 class="text-3xl font-bold text-center text-purple-600 mb-2 lg:mb-4">Forgot Password</h1>
            <p class="text-gray-500 text-center mb-6">
                {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
            </p>
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                <div class="mb-4">
                    <x-input-label for="login_by" :value="__('username / Email')" />
                    <x-text-input id="login_by"
                        class="block mt-1 w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition duration-200"
                        type="text" name="login_by" :value="old('login_by')" required autofocus />
                    <x-input-error :messages="$errors->get('login_by')" class="mt-2" />
                </div>
                <div class="flex items-center justify-end mt-6">
                    <x-primary-button
                        class="bg-gradient-to-r from-purple-600 to-blue-500 hover:opacity-90 text-white font-semibold py-2 px-6 rounded-lg transition duration-200">
                        {{ __('Email Password Reset Link') }}
                    </x-primary-button>
                </div>

            </form>

        </div>
    </div>

</body>

</html>