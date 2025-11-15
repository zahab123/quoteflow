<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-blue-600 leading-tight">
            {{ __('User Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md sm:rounded-lg border border-gray-200">
                <div class="p-8 text-gray-800 text-lg font-medium">
                    👋 Hello, User! Welcome to your dashboard.
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
