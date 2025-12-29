<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Schedule;
use App\Models\Subject;
use App\Models\SchoolClass;
use App\Models\Teacher;

class AdminScheduleController extends Controller
{
    public function index(Request $request)
    {
        $query = Schedule::with(['subject', 'schoolClass', 'teacher']);

        // Filter by class
        if ($request->filled('class_id')) {
            $query->where('class_id', $request->class_id);
        }

        // Filter by day
        if ($request->filled('day')) {
            $query->where('day', $request->day);
        }

        $schedules = $query->orderBy('day')
                          ->orderBy('start_time')
                          ->paginate(20);

        $classes = SchoolClass::active()->orderBy('name')->get();

        return view('admin.schedules.index', compact('schedules', 'classes'));
    }

    public function create()
    {
        $subjects = Subject::active()->orderBy('name')->get();
        $classes = SchoolClass::active()->orderBy('name')->get();
        $teachers = Teacher::active()->orderBy('name')->get();

        return view('admin.schedules.create', compact('subjects', 'classes', 'teachers'));
    }

    // API untuk mendapatkan data kelas (room)
    public function getClassData($id)
    {
        $class = SchoolClass::findOrFail($id);
        return response()->json([
            'room' => $class->room,
            'name' => $class->name,
        ]);
    }

    // API untuk mendapatkan data subject (teacher)
    public function getSubjectData($id)
    {
        $subject = Subject::with('teacher')->findOrFail($id);
        return response()->json([
            'teacher_id' => $subject->teacher_id,
            'teacher_name' => $subject->teacher ? $subject->teacher->name : null,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'class_id' => 'required|exists:classes,id',
            'teacher_id' => 'required|exists:teachers,id',
            'day' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'room' => 'required|max:50',
            'semester' => 'required|in:ganjil,genap',
            'academic_year' => 'required|integer|min:2020|max:2100',
            'notes' => 'nullable',
        ]);

        // Check for schedule conflicts
        $conflict = Schedule::where('class_id', $validated['class_id'])
                           ->where('day', $validated['day'])
                           ->where('academic_year', $validated['academic_year'])
                           ->where('semester', $validated['semester'])
                           ->where(function($query) use ($validated) {
                               $query->whereBetween('start_time', [$validated['start_time'], $validated['end_time']])
                                     ->orWhereBetween('end_time', [$validated['start_time'], $validated['end_time']])
                                     ->orWhere(function($q) use ($validated) {
                                         $q->where('start_time', '<=', $validated['start_time'])
                                           ->where('end_time', '>=', $validated['end_time']);
                                     });
                           })
                           ->exists();

        if ($conflict) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Jadwal bentrok! Sudah ada jadwal di waktu yang sama untuk kelas ini.');
        }

        Schedule::create($validated);

        return redirect()
            ->route('admin.schedules.index')
            ->with('success', 'Jadwal berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $schedule = Schedule::findOrFail($id);
        $subjects = Subject::active()->orderBy('name')->get();
        $classes = SchoolClass::active()->orderBy('name')->get();
        $teachers = Teacher::active()->orderBy('name')->get();

        return view('admin.schedules.edit', compact('schedule', 'subjects', 'classes', 'teachers'));
    }

    public function update(Request $request, $id)
    {
        $schedule = Schedule::findOrFail($id);
        
        $validated = $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'class_id' => 'required|exists:classes,id',
            'teacher_id' => 'required|exists:teachers,id',
            'day' => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'room' => 'required|max:50',
            'semester' => 'required|in:ganjil,genap',
            'academic_year' => 'required|integer|min:2020|max:2100',
            'notes' => 'nullable',
        ]);

        // Check for schedule conflicts (excluding current schedule)
        $conflict = Schedule::where('class_id', $validated['class_id'])
                           ->where('day', $validated['day'])
                           ->where('academic_year', $validated['academic_year'])
                           ->where('semester', $validated['semester'])
                           ->where('id', '!=', $id)
                           ->where(function($query) use ($validated) {
                               $query->whereBetween('start_time', [$validated['start_time'], $validated['end_time']])
                                     ->orWhereBetween('end_time', [$validated['start_time'], $validated['end_time']])
                                     ->orWhere(function($q) use ($validated) {
                                         $q->where('start_time', '<=', $validated['start_time'])
                                           ->where('end_time', '>=', $validated['end_time']);
                                     });
                           })
                           ->exists();

        if ($conflict) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Jadwal bentrok! Sudah ada jadwal di waktu yang sama untuk kelas ini.');
        }

        $schedule->update($validated);

        return redirect()
            ->route('admin.schedules.index')
            ->with('success', 'Jadwal berhasil diupdate!');
    }

    public function destroy($id)
    {
        $schedule = Schedule::findOrFail($id);
        
        // Check if schedule has registrations
        if ($schedule->registrations()->count() > 0) {
            return redirect()
                ->back()
                ->with('error', 'Tidak dapat menghapus jadwal yang sudah memiliki registrasi!');
        }

        $schedule->delete();

        return redirect()
            ->route('admin.schedules.index')
            ->with('success', 'Jadwal berhasil dihapus!');
    }
}