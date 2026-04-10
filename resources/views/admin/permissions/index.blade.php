<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Manage Permissions
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- Alerts --}}
            @if(session('success'))
                <div class="p-4 bg-green-100 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif
            @if($errors->any())
                <div class="p-4 bg-red-100 text-red-700 rounded">
                    {{ $errors->first() }}
                </div>
            @endif

            {{-- Create Permission --}}
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Create New Permission</h3>
                <form action="{{ route('admin.permissions.store') }}" method="POST" class="flex gap-3">
                    @csrf
                    <input
                        type="text"
                        name="name"
                        placeholder="e.g. edit posts"
                        value="{{ old('name') }}"
                        class="flex-1 border-gray-300 rounded shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                    />
                    <button type="submit"
                        class="px-4 py-2 bg-indigo-600  rounded hover:bg-indigo-700">
                        Create
                    </button>
                </form>
            </div>

            {{-- Assign Permissions to Role --}}
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Assign Permissions to Role</h3>
                <form action="{{ route('admin.permissions.assignToRole') }}" method="POST">
                    @csrf

                    {{-- Role Selector --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Select Role</label>
                        <select name="role_id" id="role_id"
                            class="w-full border-gray-300 rounded shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                            onchange="highlightRolePermissions(this.value)">
                            <option value="">-- Select a role --</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}">{{ ucfirst($role->name) }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Permissions Checkboxes --}}
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Select Permissions</label>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                            @foreach($permissions as $permission)
                                <label class="flex items-center gap-2 p-3 border rounded cursor-pointer hover:bg-indigo-50 permission-item"
                                    data-roles="{{ $permission->roles->pluck('id')->join(',') }}">
                                    <input
                                        type="checkbox"
                                        name="permissions[]"
                                        value="{{ $permission->id }}"
                                        class="rounded border-gray-300 text-indigo-600 perm-checkbox"
                                    />
                                    <span class="text-sm text-gray-700">{{ $permission->name }}</span>
                                </label>
                            @endforeach
                        </div>
                        @if($permissions->isEmpty())
                            <p class="text-gray-400 text-sm">No permissions created yet.</p>
                        @endif
                    </div>

                    <button type="submit"
                        class="px-4 py-2 bg-green-600  rounded hover:bg-green-700">
                        Save Permissions
                    </button>
                </form>
            </div>

            {{-- All Permissions Table --}}
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <div class="p-6 border-b">
                    <h3 class="text-lg font-semibold text-gray-800">All Permissions</h3>
                </div>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">#</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Permission</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Assigned To</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($permissions as $permission)
                        <tr>
                            <td class="px-6 py-4 text-sm text-gray-400">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-800">{{ $permission->name }}</td>
                            <td class="px-6 py-4">
                                <div class="flex flex-wrap gap-1">
                                    @forelse($permission->roles as $role)
                                        <span class="px-2 py-1 text-xs rounded-full
                                            {{ $role->name === 'teacher' ? 'bg-blue-100 text-blue-700' : '' }}
                                            {{ $role->name === 'student' ? 'bg-green-100 text-green-700' : '' }}
                                            {{ $role->name === 'user'    ? 'bg-gray-100 text-gray-700' : '' }}">
                                            {{ ucfirst($role->name) }}
                                        </span>
                                    @empty
                                        <span class="text-gray-400 text-xs">None</span>
                                    @endforelse
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <form action="{{ route('admin.permissions.destroy', $permission) }}" method="POST"
                                    onsubmit="return confirm('Delete this permission?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="px-3 py-1 bg-red-500  text-xs rounded hover:bg-red-600">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-gray-400">No permissions yet.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    {{-- Auto-check permissions when role is selected --}}
    <script>
        // Role → permissions map from PHP
        const rolePermissions = {
            @foreach($roles as $role)
                "{{ $role->id }}": [
                    @foreach($role->permissions as $rp)
                        "{{ $rp->id }}",
                    @endforeach
                ],
            @endforeach
        };

        function highlightRolePermissions(roleId) {
            const checkboxes = document.querySelectorAll('.perm-checkbox');
            const assigned = rolePermissions[roleId] || [];
            checkboxes.forEach(cb => {
                cb.checked = assigned.includes(cb.value);
            });
        }
    </script>
</x-app-layout>