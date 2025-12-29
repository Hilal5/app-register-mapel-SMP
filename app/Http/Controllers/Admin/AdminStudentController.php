<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\SchoolClass;
use Illuminate\Support\Facades\Hash;

class AdminStudentController extends Controller
{
    public function index(Request $request)
    {
        $query = User::student()->with('class');

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter by class
        if ($request->filled('class_id')) {
            $query->where('class_id', $request->class_id);
        }

        $students = $query->orderBy('name')->paginate(15);
        $classes = SchoolClass::active()->orderBy('name')->get();

        return view('admin.students.index', compact('students', 'classes'));
    }

    public function create()
    {
        $classes = SchoolClass::active()->orderBy('name')->get();
        return view('admin.students.create', compact('classes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nis' => 'required|unique:users,nis|max:20',
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'phone' => 'nullable|max:20',
            'address' => 'nullable',
            'gender' => 'required|in:L,P',
            'birth_date' => 'nullable|date',
            'class_id' => 'nullable|exists:classes,id',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['role'] = 'student';

        User::create($validated);

        return redirect()
            ->route('admin.students.index')
            ->with('success', 'Siswa berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $student = User::student()->findOrFail($id);
        $classes = SchoolClass::active()->orderBy('name')->get();
        
        return view('admin.students.edit', compact('student', 'classes'));
    }

    public function update(Request $request, $id)
    {
        $student = User::student()->findOrFail($id);
        
        $validated = $request->validate([
            'nis' => 'required|max:20|unique:users,nis,' . $id,
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|min:8',
            'phone' => 'nullable|max:20',
            'address' => 'nullable',
            'gender' => 'required|in:L,P',
            'birth_date' => 'nullable|date',
            'class_id' => 'nullable|exists:classes,id',
        ]);

        // Only update password if provided
        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $student->update($validated);

        return redirect()
            ->route('admin.students.index')
            ->with('success', 'Siswa berhasil diupdate!');
    }

    public function destroy($id)
    {
        $student = User::student()->findOrFail($id);
        
        // Check if student has registrations
        if ($student->registrations()->count() > 0) {
            return redirect()
                ->back()
                ->with('error', 'Tidak dapat menghapus siswa yang memiliki registrasi aktif!');
        }

        $student->delete();

        return redirect()
            ->route('admin.students.index')
            ->with('success', 'Siswa berhasil dihapus!');
    }
}