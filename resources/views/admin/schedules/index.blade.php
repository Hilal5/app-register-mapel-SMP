@extends('layouts.app')

@section('title', 'Kelola Jadwal')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    
    <!-- Page Header -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Kelola Jadwal</h1>
            <p class="text-gray-600 mt-2">Manajemen jadwal mata pelajaran</p>
        </div>
        <x-button href="{{ url('/admin/schedules/create') }}" variant="primary">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Jadwal
        </x-button>
    </div>

    @if(session('success'))
        <x-alert type="success" :message="session('success')" class="mb-6" />
    @endif
    @if(session('error'))
        <x-alert type="error" :message="session('error')" class="mb-6" />
    @endif

    <!-- Filter -->
    <x-card class="mb-6">
        <form method="GET" action="{{ url('/admin/schedules') }}" class="flex flex-col md:flex-row gap-4">
            <div>
                <select name="class_id" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="">Semua Kelas</option>
                    @foreach($classes as $class)
                        <option value="{{ $class->id }}" {{ request('class_id') == $class->id ? 'selected' : '' }}>
                            {{ $class->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <select name="day" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="">Semua Hari</option>
                    <option value="Senin" {{ request('day') == 'Senin' ? 'selected' : '' }}>Senin</option>
                    <option value="Selasa" {{ request('day') == 'Selasa' ? 'selected' : '' }}>Selasa</option>
                    <option value="Rabu" {{ request('day') == 'Rabu' ? 'selected' : '' }}>Rabu</option>
                    <option value="Kamis" {{ request('day') == 'Kamis' ? 'selected' : '' }}>Kamis</option>
                    <option value="Jumat" {{ request('day') == 'Jumat' ? 'selected' : '' }}>Jumat</option>
                    <option value="Sabtu" {{ request('day') == 'Sabtu' ? 'selected' : '' }}>Sabtu</option>
                </select>
            </div>
            <x-button type="submit" variant="primary">
                Filter
            </x-button>
        </form>
    </x-card>

    <!-- Schedules Table -->
    <x-card>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-100 border-b">
                        <th class="p-4 text-left font-semibold text-gray-700">Hari</th>
                        <th class="p-4 text-left font-semibold text-gray-700">Waktu</th>
                        <th class="p-4 text-left font-semibold text-gray-700">Mata Pelajaran</th>
                        <th class="p-4 text-left font-semibold text-gray-700">Kelas</th>
                        <th class="p-4 text-left font-semibold text-gray-700">Guru</th>
                        <th class="p-4 text-left font-semibold text-gray-700">Ruangan</th>
                        <th class="p-4 text-left font-semibold text-gray-700">Semester</th>
                        <th class="p-4 text-left font-semibold text-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($schedules as $schedule)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-4">
                                <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded text-sm font-medium">
                                    {{ $schedule->day }}
                                </span>
                            </td>
                            <td class="p-4">
                                <div class="font-medium text-gray-800">{{ $schedule->start_time->format('H:i') }} - {{ $schedule->end_time->format('H:i') }}</div>
                                <div class="text-xs text-gray-500">{{ $schedule->duration }} menit</div>
                            </td>
                            <td class="p-4">
                                <div class="font-semibold text-gray-800">{{ $schedule->subject->name }}</div>
                                <div class="text-xs text-gray-500">{{ $schedule->subject->code }}</div>
                            </td>
                            <td class="p-4">
                                <span class="px-2 py-1 bg-purple-100 text-purple-700 rounded text-sm font-medium">
                                    {{ $schedule->schoolClass?->name ?? 'Tidak ada kelas' }}
                                </span>
                            </td>
                            <td class="p-4 text-sm text-gray-700">{{ $schedule->teacher->name }}</td>
                            <td class="p-4">
                                <span class="px-2 py-1 bg-green-100 text-green-700 rounded text-sm">
                                    {{ $schedule->room }}
                                </span>
                            </td>
                            <td class="p-4">
                                <span class="px-2 py-1 bg-orange-100 text-orange-700 rounded text-xs capitalize">
                                    {{ $schedule->semester }}
                                </span>
                            </td>
                            <td class="p-4">
                                <div class="flex gap-2">
                                    <a href="{{ url('/admin/schedules/' . $schedule->id . '/edit') }}" 
                                       class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                        Edit
                                    </a>
                                    <form method="POST" action="{{ url('/admin/schedules/' . $schedule->id) }}"
                                          onsubmit="return confirm('Yakin ingin menghapus jadwal ini?')"
                                          class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="p-8 text-center text-gray-500">
                                Tidak ada data jadwal
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($schedules->hasPages())
            <div class="mt-4 border-t pt-4">
                {{ $schedules->links() }}
            </div>
        @endif
    </x-card>

</div>
@endsection