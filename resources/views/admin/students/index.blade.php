<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Students</h2>
            <a href="{{ route('admin.students.create') }}"
                class="px-4 py-2 bg-indigo-600 text-black rounded hover:bg-indigo-700 text-sm">
                + Add Student
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">{{ session('success') }}</div>
            @endif

            <div class="bg-white shadow rounded-lg overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">#</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Phone</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Enrollment Year</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Courses</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($students as $student)
                        <tr>
                            <td class="px-6 py-4 text-sm text-gray-400">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-800">{{ $student->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $student->email }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $student->phone ?? '—' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $student->enrollment_year }}</td>
                            <td class="px-6 py-4">
                                <div class="flex flex-wrap gap-1">
                                    @forelse($student->courses as $course)
                                        <span class="px-2 py-1 text-xs bg-blue-100 text-blue-700 rounded-full">
                                            {{ $course->name }}
                                        </span>
                                    @empty
                                        <span class="text-gray-400 text-xs">None</span>
                                    @endforelse
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex gap-2">
                                    <a href="{{ route('admin.students.show', $student) }}"
                                        class="px-3 py-1 bg-gray-100 text-gray-700 text-xs rounded hover:bg-gray-200">
                                        View
                                    </a>
                                    <a href="{{ route('admin.students.edit', $student) }}"
                                        class="px-3 py-1 bg-yellow-100 text-yellow-700 text-xs rounded hover:bg-yellow-200">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.students.destroy', $student) }}" method="POST"
                                        onsubmit="return confirm('Delete this student?')">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                            class="px-3 py-1 bg-red-100 text-red-700 text-xs rounded hover:bg-red-200">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-gray-400">No students found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="p-4">{{ $students->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>