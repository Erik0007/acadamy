<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Course;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::with('courses')->latest()->paginate(10);
        return view('admin.students.index', compact('students'));
    }

    public function create()
    {
        $courses = Course::all();
        return view('admin.students.create', compact('courses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'            => ['required', 'string', 'max:255'],
            'email'           => ['required', 'email', 'unique:students,email'],
            'phone'           => ['nullable', 'string', 'max:20'],
            'address'         => ['nullable', 'string'],
            'enrollment_year' => ['required', 'digits:4', 'integer', 'min:2000', 'max:' . (date('Y') + 1)],
            'courses'         => ['nullable', 'array'],
            'courses.*'       => ['exists:courses,id'],
        ]);

        $student = Student::create($request->only(
            'name', 'email', 'phone', 'address', 'enrollment_year'
        ));

        if ($request->filled('courses')) {
            $student->courses()->sync($request->courses);
        }

        return redirect()->route('admin.students.index')
            ->with('success', "Student '{$student->name}' created successfully.");
    }

    public function show(Student $student)
    {
        $student->load('courses');
        return view('admin.students.show', compact('student'));
    }

    public function edit(Student $student)
    {
        $courses = Course::all();
        $assignedCourses = $student->courses->pluck('id')->toArray();
        return view('admin.students.edit', compact('student', 'courses', 'assignedCourses'));
    }

    public function update(Request $request, Student $student)
    {
        $request->validate([
            'name'            => ['required', 'string', 'max:255'],
            'email'           => ['required', 'email', 'unique:students,email,' . $student->id],
            'phone'           => ['nullable', 'string', 'max:20'],
            'address'         => ['nullable', 'string'],
            'enrollment_year' => ['required', 'digits:4', 'integer', 'min:2000', 'max:' . (date('Y') + 1)],
            'courses'         => ['nullable', 'array'],
            'courses.*'       => ['exists:courses,id'],
        ]);

        $student->update($request->only(
            'name', 'email', 'phone', 'address', 'enrollment_year'
        ));

        $student->courses()->sync($request->courses ?? []);

        return redirect()->route('admin.students.index')
            ->with('success', "Student '{$student->name}' updated successfully.");
    }

    public function destroy(Student $student)
    {
        $student->courses()->detach();
        $student->delete();

        return redirect()->route('admin.students.index')
            ->with('success', "Student deleted successfully.");
    }
}