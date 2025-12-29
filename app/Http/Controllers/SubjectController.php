<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subject;

class SubjectController extends Controller
{
    /**
     * Display a listing of subjects.
     */
    public function index(Request $request)
    {
        $query = Subject::with('teacher');

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%");
            });
        }

        // Filter by semester
        if ($request->filled('semester')) {
            $query->where('semester', $request->semester);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        } else {
            // Default: hanya tampilkan yang aktif
            $query->where('status', 'active');
        }

        $subjects = $query->orderBy('name')->paginate(9);

        // Manually add registered_count untuk setiap subject
        foreach ($subjects as $subject) {
            $subject->registered_count = $subject->registrations()
                ->where('status', 'approved')
                ->count();
        }

        return view('subjects.index', compact('subjects'));
    }

    /**
     * Display the specified subject.
     */
    public function show($id)
    {
        // ✅ FIXED: 'schedules.class' → 'schedules.schoolClass'
        $subject = Subject::with(['teacher', 'schedules.schoolClass', 'schedules.teacher'])
                          ->findOrFail($id);

        // Manually add registered_count
        $subject->registered_count = $subject->registrations()
            ->where('status', 'approved')
            ->count();

        return view('subjects.show', compact('subject'));
    }

    /**
     * Show the form for creating a new subject (Admin only).
     */
    public function create()
    {
        // TODO: Add middleware untuk admin only
        return view('subjects.create');
    }

    /**
     * Store a newly created subject (Admin only).
     */
    public function store(Request $request)
    {
        // TODO: Add validation and middleware
        $validated = $request->validate([
            'code' => 'required|unique:subjects',
            'name' => 'required',
            'description' => 'nullable',
            'credits' => 'required|integer|min:1',
            'teacher_id' => 'nullable|exists:teachers,id',
            'semester' => 'required|in:ganjil,genap',
            'quota' => 'required|integer|min:1',
        ]);

        $subject = Subject::create($validated);

        return redirect()
            ->route('subjects.index')
            ->with('success', 'Mata pelajaran berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the subject (Admin only).
     */
    public function edit($id)
    {
        // TODO: Add middleware
        $subject = Subject::findOrFail($id);
        return view('subjects.edit', compact('subject'));
    }

    /**
     * Update the specified subject (Admin only).
     */
    public function update(Request $request, $id)
    {
        // TODO: Add validation and middleware
        $subject = Subject::findOrFail($id);
        
        $validated = $request->validate([
            'code' => 'required|unique:subjects,code,' . $id,
            'name' => 'required',
            'description' => 'nullable',
            'credits' => 'required|integer|min:1',
            'teacher_id' => 'nullable|exists:teachers,id',
            'semester' => 'required|in:ganjil,genap',
            'quota' => 'required|integer|min:1',
        ]);

        $subject->update($validated);

        return redirect()
            ->route('subjects.show', $id)
            ->with('success', 'Mata pelajaran berhasil diupdate!');
    }

    /**
     * Remove the specified subject (Admin only).
     */
    public function destroy($id)
    {
        // TODO: Add middleware
        $subject = Subject::findOrFail($id);
        $subject->delete();

        return redirect()
            ->route('subjects.index')
            ->with('success', 'Mata pelajaran berhasil dihapus!');
    }
}