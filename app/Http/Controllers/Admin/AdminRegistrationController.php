<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Registration;

class AdminRegistrationController extends Controller
{
    public function index(Request $request)
    {
        $query = Registration::with(['user', 'subject', 'schedule.teacher', 'schedule.schoolClass']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search by student name
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nis', 'like', "%{$search}%");
            });
        }

        $registrations = $query->orderBy('created_at', 'desc')->paginate(20);

        $stats = [
            'total' => Registration::count(),
            'pending' => Registration::pending()->count(),
            'approved' => Registration::where('status', 'approved')->count(),
            'rejected' => Registration::where('status', 'rejected')->count(),
        ];

        return view('admin.registrations.index', compact('registrations', 'stats'));
    }

    public function approve($id)
    {
        $registration = Registration::findOrFail($id);

        if ($registration->status != 'pending') {
            return redirect()
                ->back()
                ->with('error', 'Registrasi ini sudah diproses!');
        }

        // Check if subject quota is still available
        $subject = $registration->subject;
        $approvedCount = $subject->registrations()
            ->where('status', 'approved')
            ->count();

        if ($approvedCount >= $subject->quota) {
            return redirect()
                ->back()
                ->with('error', 'Kuota mata pelajaran sudah penuh!');
        }

        $registration->approve();

        return redirect()
            ->back()
            ->with('success', 'Registrasi berhasil disetujui!');
    }

    public function reject(Request $request, $id)
    {
        $registration = Registration::findOrFail($id);

        if ($registration->status != 'pending') {
            return redirect()
                ->back()
                ->with('error', 'Registrasi ini sudah diproses!');
        }

        $registration->reject();

        // Optional: Save rejection reason
        if ($request->filled('notes')) {
            $registration->update(['notes' => $request->notes]);
        }

        return redirect()
            ->back()
            ->with('success', 'Registrasi berhasil ditolak!');
    }

    public function destroy($id)
    {
        $registration = Registration::findOrFail($id);
        $registration->delete();

        return redirect()
            ->back()
            ->with('success', 'Registrasi berhasil dihapus!');
    }

    public function bulkApprove(Request $request)
    {
        $ids = $request->input('registration_ids', []);
        
        if (empty($ids)) {
            return redirect()
                ->back()
                ->with('error', 'Tidak ada registrasi yang dipilih!');
        }

        $updated = 0;
        foreach ($ids as $id) {
            $registration = Registration::find($id);
            if ($registration && $registration->status == 'pending') {
                $subject = $registration->subject;
                $approvedCount = $subject->registrations()
                    ->where('status', 'approved')
                    ->count();

                if ($approvedCount < $subject->quota) {
                    $registration->approve();
                    $updated++;
                }
            }
        }

        return redirect()
            ->back()
            ->with('success', "{$updated} registrasi berhasil disetujui!");
    }

    public function bulkReject(Request $request)
    {
        $ids = $request->input('registration_ids', []);
        
        if (empty($ids)) {
            return redirect()
                ->back()
                ->with('error', 'Tidak ada registrasi yang dipilih!');
        }

        $updated = Registration::whereIn('id', $ids)
                              ->where('status', 'pending')
                              ->update(['status' => 'rejected']);

        return redirect()
            ->back()
            ->with('success', "{$updated} registrasi berhasil ditolak!");
    }
}