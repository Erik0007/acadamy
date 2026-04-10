<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Add Student</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg p-6">

                @if($errors->any())
                    <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                        <ul class="list-disc pl-4">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.students.store') }}" method="POST">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Name *</label>
                            <input type="text" name="name" value="{{ old('name') }}"
                                class="w-full border-gray-300 rounded shadow-sm focus:ring-indigo-500" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                            <input type="email" name="email" value="{{ old('email') }}"
                                class="w-full border-gray-300 rounded shadow-sm focus:ring-indigo-500" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                            <input type="text" name="phone" value="{{ old('phone') }}"
                                class="w-full border-gray-300 rounded shadow-sm focus:ring-indigo-500" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Enrollment Year *</label>
                            <input type="number" name="enrollment_year" value="{{ old('enrollment_year', date('Y')) }}"
                                min="2000" max="{{ date('Y') + 1 }}"
                                class="w-full border-gray-300 rounded shadow-sm focus:ring-indigo-500" />
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                            <textarea name="address" rows="2"
                                class="w-full border-gray-300 rounded shadow-sm focus:ring-indigo-500">{{ old('address') }}</textarea>
                        </div>

                        {{-- Assign Courses --}}
                        @if($courses->isNotEmpty())
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Assign Courses</label>
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
                                @foreach($courses as $course)
                                    <label class="flex items-center gap-2 p-2 border rounded cursor-pointer hover:bg-indigo-50">
                                        <input type="checkbox" name="courses[]" value="{{ $course->id }}"
                                            {{ in_array($course->id, old('courses', [])) ? 'checked' : '' }}
                                            class="rounded border-gray-300 text-indigo-600" />
                                        <span class="text-sm text-gray-700">{{ $course->name }}</span>
                                        <span class="text-xs text-gray-400">({{ $course->code }})</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>

                    <div class="mt-6 flex gap-3">
                        <button type="submit"
                            class="px-4 py-2 bg-indigo-600  rounded hover:bg-indigo-700">
                            Create Student
                        </button>
                        <a href="{{ route('admin.students.index') }}"
                            class="px-4 py-2 bg-gray-100 text-gray-700 rounded hover:bg-gray-200">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>