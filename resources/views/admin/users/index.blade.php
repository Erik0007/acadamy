<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Manage Users
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow rounded-lg overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Current Role</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Change Role</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($users as $user)
                        <tr>
                            <td class="px-6 py-4 text-sm text-gray-800">{{ $user->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $user->email }}</td>
                            <td class="px-6 py-4">
                                @foreach($user->roles as $role)
                                    <span class="px-2 py-1 text-xs rounded-full
                                        {{ $role->name === 'teacher' ? 'bg-blue-100 text-blue-700' : '' }}
                                        {{ $role->name === 'student' ? 'bg-green-100 text-green-700' : '' }}
                                        {{ $role->name === 'user' ? 'bg-gray-100 text-gray-700' : '' }}">
                                        {{ ucfirst($role->name) }}
                                    </span>
                                @endforeach
                            </td>
                            <td class="px-6 py-4">
                                <form action="{{ route('admin.users.updateRole', $user) }}" method="POST" class="flex gap-2">
                                    @csrf
                                    <select name="role" class="text-sm border-gray-300 rounded shadow-sm">
                                        <option value="user"    {{ $user->selected_role === 'user'    ? 'selected' : '' }}>User</option>
                                        <option value="student" {{ $user->selected_role === 'student' ? 'selected' : '' }}>Student</option>
                                        <option value="teacher" {{ $user->selected_role === 'teacher' ? 'selected' : '' }}>Teacher</option>
                                    </select>
                                    <button type="submit"
                                        class="px-3 py-1 bg-indigo-600 text-white text-sm rounded hover:bg-indigo-700">
                                        Update
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-400">No users found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>