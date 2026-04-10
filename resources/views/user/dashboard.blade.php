<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            User Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-2">Welcome, {{ auth()->user()->name }}</h3>
                <p class="text-gray-600">You are logged in as <span class="font-bold text-blue-500">User</span>.</p>
            </div>
        </div>
    </div>
</x-app-layout>