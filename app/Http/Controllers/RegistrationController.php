<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subject;
use App\Models\Registration;
use App\Models\Schedule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RegistrationController extends Controller
{
    /**
     * Display registration page with available subjects.
     */
    public function index()
    {
        $subjects = Subject::with(['teacher', 'schedules.schoolClass'])
                          ->where('status', 'active')
                          ->where('semester', 'ganjil')
                          ->orderBy('name')
                          ->paginate(9);

        // Add registered_count manually
        foreach ($subjects as $subject) {
            $subject->registered_count = $subject->registrations()
                ->where('status', 'approved')
                ->count();
        }

        return view('registrations.index', compact('subjects'));
    }

    /**
     * Register student to a subject.
     */
    public function register(Request $request)
    {
        // Validate input
        $validated = $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'schedule_id' => 'required|exists:schedules,id',
        ]);

        $userId = Auth::id();

        // Check if subject quota is full
        $subject = Subject::findOrFail($validated['subject_id']);
        
        $registeredCount = $subject->registrations()
            ->where('status', 'approved')
            ->count();

        if ($registeredCount >= $subject->quota) {
            return redirect()
                ->back()
                ->with('error', 'Kuota mata pelajaran sudah penuh!');
        }

        // Check if student already registered for this subject
        $existingRegistration = Registration::where('user_id', $userId)
                                           ->where('subject_id', $validated['subject_id'])
                                           ->where('schedule_id', $validated['schedule_id'])
                                           ->whereIn('status', ['pending', 'approved'])
                                           ->first();

        if ($existingRegistration) {
            return redirect()
                ->back()
                ->with('error', 'Kamu sudah terdaftar di mata pelajaran ini!');
        }

        // Check for schedule conflicts
        $schedule = Schedule::findOrFail($validated['schedule_id']);
        
        $conflictingSchedule = Registration::where('user_id', $userId)
                                          ->whereHas('schedule', function($q) use ($schedule) {
                                              $q->where('day', $schedule->day)
                                                ->where(function($query) use ($schedule) {
                                                    // Check if times overlap
                                                    $query->whereBetween('start_time', [$schedule->start_time, $schedule->end_time])
                                                          ->orWhereBetween('end_time', [$schedule->start_time, $schedule->end_time])
                                                          ->orWhere(function($q) use ($schedule) {
                                                              $q->where('start_time', '<=', $schedule->start_time)
                                                                ->where('end_time', '>=', $schedule->end_time);
                                                          });
                                                });
                                          })
                                          ->whereIn('status', ['pending', 'approved'])
                                          ->exists();

        if ($conflictingSchedule) {
            return redirect()
                ->back()
                ->with('error', 'Jadwal bentrok dengan mata pelajaran lain yang sudah kamu daftarkan!');
        }

        // Create registration
        try {
            Registration::create([
                'user_id' => $userId,
                'subject_id' => $validated['subject_id'],
                'schedule_id' => $validated['schedule_id'],
                'status' => 'approved', // Auto approve for now
                'registration_date' => now(),
            ]);

            return redirect()
                ->route('registrations.my')
                ->with('success', 'Berhasil mendaftar mata pelajaran!');
        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->with('error', 'Gagal mendaftar. Silakan coba lagi.');
        }
    }

    /**
     * Display user's registrations.
     */
    public function myRegistrations()
    {
        $userId = Auth::id();

        $registrations = Registration::with(['subject', 'schedule.teacher', 'schedule.schoolClass'])
                                    ->where('user_id', $userId)
                                    ->orderBy('created_at', 'desc')
                                    ->get();

        return view('registrations.my-registrations', compact('registrations'));
    }

    /**
     * Cancel a registration.
     */
    public function cancel($id)
    {
        $userId = Auth::id();

        $registration = Registration::where('id', $id)
                                   ->where('user_id', $userId)
                                   ->firstOrFail();

        // Only allow cancelling pending or approved registrations
        if (!in_array($registration->status, ['pending', 'approved'])) {
            return redirect()
                ->back()
                ->with('error', 'Registrasi ini tidak dapat dibatalkan!');
        }

        $registration->cancel();

        return redirect()
            ->back()
            ->with('success', 'Registrasi berhasil dibatalkan!');
    }
}