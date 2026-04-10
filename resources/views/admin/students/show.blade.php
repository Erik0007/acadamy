<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Student — {{ $student->name }}</h2>
            <a href="{{ route('admin.students.edit', $student) }}"
                class="px-4 py-2 bg-yellow-500  rounded hover:bg-yellow-600 text-sm">
                Edit
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Student Details</h3>
                <dl class="grid grid-cols-2 gap-4">
                    <div>
                        <dt class="text-xs text-gray-500 uppercase">Name</dt>
                        <dd class="text-sm font-medium text-gray-800">{{ $student->name }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-gray-500 uppercase">Email</dt>
                        <dd class="text-sm text-gray-800">{{ $student->email }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-gray-500 uppercase">Phone</dt>
                        <dd class="text-sm text-gray-800">{{ $student->phone ?? '—' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-gray-500 uppercase">Enrollment Year</dt>
                        <dd class="text-sm text-gray-800">{{ $student->enrollment_year }}</dd>
                    </div>
                    <div class="col-span-2">
                        <dt class="text-xs text-gray-500 uppercase">Address</dt>
                        <dd class="text-sm text-gray-800">{{ $student->address ?? '—' }}</dd>
                    </div>
                </dl>
            </div>

            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Enrolled Courses</h3>
                @forelse($student->courses as $course)
                    <div class="flex items-center justify-between py-2 border-b last:border-0">
                        <div>
                            <p class="text-sm font-medium text-gray-800">{{ $course->name }}</p>
                            <p class="text-xs text-gray-400">{{ $course->code }}</p>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-400 text-sm">Not enrolled in any courses.</p>
                @endforelse
            </div>

            <div class="flex gap-3">
                <a href="{{ route('admin.students.index') }}"
                    class="px-4 py-2 bg-gray-100 text-gray-700 rounded hover:bg-gray-200 text-sm">
                    ← Back to Students
                </a>
                <form action="{{ route('admin.students.destroy', $student) }}" method="POST"
                    onsubmit="return confirm('Delete this student?')">
                    @csrf @method('DELETE')
                    <button type="submit"
                        class="px-4 py-2 bg-red-500  rounded hover:bg-red-600 text-sm">
                        Delete Student
                    </button>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>