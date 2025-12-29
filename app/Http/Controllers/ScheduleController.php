<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Schedule;
use App\Models\SchoolClass;

class ScheduleController extends Controller
{
    /**
     * Display a listing of schedules.
     */
    public function index(Request $request)
    {
        // ✅ FIXED: 'class' → 'schoolClass'
        $query = Schedule::with(['subject', 'schoolClass', 'teacher']);

        // Filter by class
        if ($request->filled('class')) {
            $query->where('class_id', $request->class);
        }

        // Filter by day
        if ($request->filled('day')) {
            $query->where('day', $request->day);
        }

        // Search by subject
        if ($request->filled('subject')) {
            $search = $request->subject;
            $query->whereHas('subject', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%");
            });
        }

        // Default: current semester and academic year
        $query->where('semester', 'ganjil')
              ->where('academic_year', 2025);

        $schedules = $query->orderBy('day')
                           ->orderBy('start_time')
                           ->paginate(20);

        // Get all classes for filter dropdown
        $classes = SchoolClass::active()->orderBy('name')->get();

        return view('schedules.index', compact('schedules', 'classes'));
    }

    /**
     * Display schedules by class.
     */
    public function byClass($classId)
    {
        $class = SchoolClass::findOrFail($classId);
        
        $schedules = Schedule::with(['subject', 'teacher'])
                            ->where('class_id', $classId)
                            ->where('semester', 'ganjil')
                            ->where('academic_year', 2025)
                            ->orderBy('day')
                            ->orderBy('start_time')
                            ->get();

        return view('schedules.by-class', compact('schedules', 'class'));
    }

    /**
     * Display schedules by day.
     */
    public function byDay($day)
    {
        // ✅ FIXED: 'class' → 'schoolClass'
        $schedules = Schedule::with(['subject', 'schoolClass', 'teacher'])
                            ->where('day', $day)
                            ->where('semester', 'ganjil')
                            ->where('academic_year', 2025)
                            ->orderBy('start_time')
                            ->get();

        return view('schedules.by-day', compact('schedules', 'day'));
    }
}