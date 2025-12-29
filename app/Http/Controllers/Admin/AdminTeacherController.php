<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Teacher;

class AdminTeacherController extends Controller
{
    public function index()
    {
        $teachers = Teacher::orderBy('name')->paginate(15);
        return view('admin.teachers.index', compact('teachers'));
    }

    public function create()
    {
        return view('admin.teachers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nip' => 'required|unique:teachers,nip|max:20',
            'name' => 'required|max:255',
            'email' => 'required|email|unique:teachers,email',
            'phone' => 'nullable|max:20',
            'address' => 'nullable',
            'gender' => 'required|in:L,P',
            'birth_date' => 'nullable|date',
            'status' => 'required|in:active,inactive',
        ]);

        Teacher::create($validated);

        return redirect()
            ->route('admin.teachers.index')
            ->with('success', 'Guru berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $teacher = Teacher::findOrFail($id);
        return view('admin.teachers.edit', compact('teacher'));
    }

    public function update(Request $request, $id)
    {
        $teacher = Teacher::findOrFail($id);
        
        $validated = $request->validate([
            'nip' => 'required|max:20|unique:teachers,nip,' . $id,
            'name' => 'required|max:255',
            'email' => 'required|email|unique:teachers,email,' . $id,
            'phone' => 'nullable|max:20',
            'address' => 'nullable',
            'gender' => 'required|in:L,P',
            'birth_date' => 'nullable|date',
            'status' => 'required|in:active,inactive',
        ]);

        $teacher->update($validated);

        return redirect()
            ->route('admin.teachers.index')
            ->with('success', 'Guru berhasil diupdate!');
    }

    public function destroy($id)
    {
        $teacher = Teacher::findOrFail($id);
        
        // Check if teacher has subjects
        if ($teacher->subjects()->count() > 0) {
            return redirect()
                ->back()
                ->with('error', 'Tidak dapat menghapus guru yang masih mengampu mata pelajaran!');
        }

        $teacher->delete();

        return redirect()
            ->route('admin.teachers.index')
            ->with('success', 'Guru berhasil dihapus!');
    }
}