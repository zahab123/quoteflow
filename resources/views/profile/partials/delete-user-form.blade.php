<section class="space-y-6 bg-white rounded-xl shadow p-6">
    <header>
        <h2 class="text-2xl font-bold text-gray-800">
            {{ __('Delete Account') }}
        </h2>

        <p class="mt-2 text-gray-500 text-sm">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg shadow"
    >
        {{ __('Delete Account') }}
    </x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6 space-y-4">
            @csrf
            @method('delete')

            <h2 class="text-lg font-bold text-gray-800">
                {{ __('Are you sure you want to delete your account?') }}
            </h2>

            <p class="mt-1 text-gray-500 text-sm">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
            </p>

            <div class="mt-4">
                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-full md:w-3/4 border rounded-lg shadow-sm px-3 py-2 focus:outline-none focus:ring focus:border-purple-300"
                    placeholder="{{ __('Password') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2 text-red-600" />
            </div>

            <div class="mt-6 flex justify-end gap-3">
                <x-secondary-button x-on:click="$dispatch('close')" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-lg shadow">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg shadow">
                    {{ __('Delete Account') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
