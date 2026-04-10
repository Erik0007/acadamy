<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Admin Dashboard
        </h2>
    </x-slot>

    {{-- Nav Items --}}
    <div class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-6">
            <nav class="flex space-x-1">
                <a href="{{ route('admin.dashboard') }}"
                    class="px-4 py-3 text-sm font-medium text-indigo-600 border-b-2 border-indigo-600">
                    Dashboard
                </a>
                <a href="{{ route('admin.users.index') }}"
                    class="px-4 py-3 text-sm font-medium text-gray-500 hover:text-indigo-600 hover:border-b-2 hover:border-indigo-400 transition">
                    Manage Users
                </a>
                <a href="{{ route('admin.permissions.index') }}"
                    class="px-4 py-3 text-sm font-medium text-gray-500 hover:text-indigo-600 hover:border-b-2 hover:border-indigo-400 transition">
                    Manage Permissions
                </a>
                <a href="{{ route('admin.students.index') }}"
                    class="px-4 py-3 text-sm font-medium text-gray-500 hover:text-indigo-600 hover:border-b-2 hover:border-indigo-400 transition">
                    Manage Students
                </a>
            </nav>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-2">Welcome, {{ auth()->user()->name }}</h3>
                <p class="text-gray-600">You are logged in as <span class="font-bold text-red-500">Admin</span>.</p>
            </div>

        </div>
    </div>
</x-app-layout>