@extends('layouts.app')

@section('title', 'Kelola Registrasi')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Kelola Registrasi</h1>
        <p class="text-gray-600 mt-2">Approve atau reject registrasi siswa</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
        <x-card class="bg-blue-50">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-blue-600 font-medium">Total Registrasi</p>
                    <h3 class="text-2xl font-bold text-blue-700 mt-1">{{ $stats['total'] }}</h3>
                </div>
                <svg class="w-10 h-10 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
            </div>
        </x-card>

        <x-card class="bg-yellow-50">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-yellow-600 font-medium">Pending</p>
                    <h3 class="text-2xl font-bold text-yellow-700 mt-1">{{ $stats['pending'] }}</h3>
                </div>
                <svg class="w-10 h-10 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </x-card>

        <x-card class="bg-green-50">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-green-600 font-medium">Approved</p>
                    <h3 class="text-2xl font-bold text-green-700 mt-1">{{ $stats['approved'] }}</h3>
                </div>
                <svg class="w-10 h-10 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </x-card>

        <x-card class="bg-red-50">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-red-600 font-medium">Rejected</p>
                    <h3 class="text-2xl font-bold text-red-700 mt-1">{{ $stats['rejected'] }}</h3>
                </div>
                <svg class="w-10 h-10 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </x-card>
    </div>

    <!-- Messages -->
    @if(session('success'))
        <x-alert type="success" :message="session('success')" class="mb-6" />
    @endif
    @if(session('error'))
        <x-alert type="error" :message="session('error')" class="mb-6" />
    @endif

    <!-- Filter & Actions -->
    <x-card class="mb-6">
        <form method="GET" action="{{ url('/admin/registrations') }}" class="flex flex-col md:flex-row gap-4">
            <div class="flex-1">
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Cari siswa (nama/NIS)..."
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <select name="status" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>
            <x-button type="submit" variant="primary">
                Filter
            </x-button>
        </form>
    </x-card>

    <!-- Registrations Table -->
    <x-card>
        <form id="bulkForm">
            @csrf
            <div class="flex justify-between items-center mb-4">
                <div class="flex gap-2">
                    <button type="button" onclick="bulkApprove()" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 text-sm">
                        Approve Terpilih
                    </button>
                    <button type="button" onclick="bulkReject()" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 text-sm">
                        Reject Terpilih
                    </button>
                </div>
                <label class="text-sm text-gray-600">
                    <input type="checkbox" id="selectAll" onchange="toggleSelectAll(this)"> Pilih Semua
                </label>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-100 border-b">
                            <th class="p-4 text-left">
                                <input type="checkbox" id="selectAllHeader" onchange="toggleSelectAll(this)">
                            </th>
                            <th class="p-4 text-left font-semibold text-gray-700">Siswa</th>
                            <th class="p-4 text-left font-semibold text-gray-700">Mata Pelajaran</th>
                            <th class="p-4 text-left font-semibold text-gray-700">Jadwal</th>
                            <th class="p-4 text-left font-semibold text-gray-700">Kelas</th>
                            <th class="p-4 text-left font-semibold text-gray-700">Tanggal</th>
                            <th class="p-4 text-left font-semibold text-gray-700">Status</th>
                            <th class="p-4 text-left font-semibold text-gray-700">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($registrations as $reg)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="p-4">
                                    @if($reg->status == 'pending')
                                        <input type="checkbox" name="registration_ids[]" value="{{ $reg->id }}" class="registration-checkbox">
                                    @endif
                                </td>
                                <td class="p-4">
                                    <div class="font-semibold text-gray-800">{{ $reg->user->name }}</div>
                                    <div class="text-xs text-gray-500">NIS: {{ $reg->user->nis }}</div>
                                </td>
                                <td class="p-4">
                                    <div class="font-medium text-gray-800">{{ $reg->subject->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $reg->subject->code }}</div>
                                </td>
                                <td class="p-4">
                                    <div class="text-sm text-gray-700">{{ $reg->schedule->day }}</div>
                                    <div class="text-xs text-gray-500">{{ $reg->schedule->time_range }}</div>
                                </td>
                                <td class="p-4">
                                    <span class="px-2 py-1 bg-purple-100 text-purple-700 rounded text-xs">
                                        {{ $reg->schedule->class->name }}
                                    </span>
                                </td>
                                <td class="p-4 text-sm text-gray-600">
                                    {{ $reg->registration_date->format('d M Y') }}
                                </td>
                                <td class="p-4">
                                    @if($reg->status == 'approved')
                                        <span class="px-2 py-1 bg-green-100 text-green-700 rounded-full text-xs font-medium">Approved</span>
                                    @elseif($reg->status == 'pending')
                                        <span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded-full text-xs font-medium">Pending</span>
                                    @elseif($reg->status == 'rejected')
                                        <span class="px-2 py-1 bg-red-100 text-red-700 rounded-full text-xs font-medium">Rejected</span>
                                    @else
                                        <span class="px-2 py-1 bg-gray-100 text-gray-700 rounded-full text-xs font-medium">Cancelled</span>
                                    @endif
                                </td>
                                <td class="p-4">
                                    <div class="flex gap-2">
                                        @if($reg->status == 'pending')
                                            <form method="POST" action="{{ url('/admin/registrations/' . $reg->id . '/approve') }}" class="inline">
                                                @csrf
                                                <button type="submit" class="text-green-600 hover:text-green-800 text-sm font-medium">
                                                    Approve
                                                </button>
                                            </form>
                                            <form method="POST" action="{{ url('/admin/registrations/' . $reg->id . '/reject') }}" class="inline">
                                                @csrf
                                                <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium">
                                                    Reject
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-gray-400 text-sm">-</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="p-8 text-center text-gray-500">
                                    Tidak ada data registrasi
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </form>

        @if($registrations->hasPages())
            <div class="mt-4 border-t pt-4">
                {{ $registrations->links() }}
            </div>
        @endif
    </x-card>

</div>

@push('scripts')
<script>
    function toggleSelectAll(checkbox) {
        const checkboxes = document.querySelectorAll('.registration-checkbox');
        checkboxes.forEach(cb => cb.checked = checkbox.checked);
    }

    function bulkApprove() {
        const selected = document.querySelectorAll('.registration-checkbox:checked');
        if (selected.length === 0) {
            alert('Pilih registrasi yang ingin diapprove!');
            return;
        }
        
        if (confirm(`Approve ${selected.length} registrasi terpilih?`)) {
            const form = document.getElementById('bulkForm');
            form.action = '{{ url("/admin/registrations/bulk-approve") }}';
            form.method = 'POST';
            form.submit();
        }
    }

    function bulkReject() {
        const selected = document.querySelectorAll('.registration-checkbox:checked');
        if (selected.length === 0) {
            alert('Pilih registrasi yang ingin direject!');
            return;
        }
        
        if (confirm(`Reject ${selected.length} registrasi terpilih?`)) {
            const form = document.getElementById('bulkForm');
            form.action = '{{ url("/admin/registrations/bulk-reject") }}';
            form.method = 'POST';
            form.submit();
        }
    }
</script>
@endpush
@endsection