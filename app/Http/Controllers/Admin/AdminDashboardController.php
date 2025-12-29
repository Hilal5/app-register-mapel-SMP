<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Subject;
use App\Models\SchoolClass;
use App\Models\Teacher;
use App\Models\Registration;
use App\Models\Schedule;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'totalStudents' => User::student()->count(),
            'totalTeachers' => Teacher::active()->count(),
            'totalSubjects' => Subject::active()->count(),
            'totalClasses' => SchoolClass::active()->count(),
            'pendingRegistrations' => Registration::pending()->count(),
            'approvedRegistrations' => Registration::where('status', 'approved')->count(),
            'totalSchedules' => Schedule::count(),
        ];

        // Recent registrations
        $recentRegistrations = Registration::with(['user', 'subject', 'schedule'])
                                          ->latest()
                                          ->limit(5)
                                          ->get();

        // Recent students
        $recentStudents = User::student()
                             ->with('class')
                             ->latest()
                             ->limit(5)
                             ->get();

        // Recent schedules
        $recentSchedules = Schedule::with(['subject', 'teacher', 'schoolClass'])
                                   ->latest()
                                   ->limit(5)
                                   ->get();

        // Recent subjects
        $recentSubjects = Subject::active()
                                ->latest()
                                ->limit(5)
                                ->get();

        // Recent teachers
        $recentTeachers = Teacher::active()
                                ->latest()
                                ->limit(5)
                                ->get();

        return view('admin.dashboard', compact(
            'stats',
            'recentRegistrations',
            'recentStudents',
            'recentSchedules',
            'recentSubjects',
            'recentTeachers'
        ));
    }
}