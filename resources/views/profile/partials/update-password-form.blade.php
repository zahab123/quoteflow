<section class="bg-white rounded-xl shadow p-6 space-y-6">
    <header>
        <h2 class="text-2xl font-bold text-gray-800">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-2 text-gray-500 text-sm">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <x-input-label for="update_password_current_password" :value="__('Current Password')" />
            <x-text-input 
                id="update_password_current_password" 
                name="current_password" 
                type="password" 
                class="mt-1 block w-full border rounded-lg shadow-sm px-3 py-2 focus:outline-none focus:ring focus:border-purple-300" 
                autocomplete="current-password" 
            />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2 text-red-600" />
        </div>

        <div>
            <x-input-label for="update_password_password" :value="__('New Password')" />
            <x-text-input 
                id="update_password_password" 
                name="password" 
                type="password" 
                class="mt-1 block w-full border rounded-lg shadow-sm px-3 py-2 focus:outline-none focus:ring focus:border-purple-300" 
                autocomplete="new-password" 
            />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2 text-red-600" />
        </div>

        <div>
            <x-input-label for="update_password_password_confirmation" :value="__('Confirm Password')" />
            <x-text-input 
                id="update_password_password_confirmation" 
                name="password_confirmation" 
                type="password" 
                class="mt-1 block w-full border rounded-lg shadow-sm px-3 py-2 focus:outline-none focus:ring focus:border-purple-300" 
                autocomplete="new-password" 
            />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2 text-red-600" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg shadow">
                {{ __('Save') }}
            </x-primary-button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-500"
                >
                    {{ __('Saved.') }}
                </p>
            @endif
        </div>
    </form>
</section>
