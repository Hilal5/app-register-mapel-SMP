@extends('layouts.app')

@section('title', 'Jadwal Pelajaran')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Jadwal Pelajaran</h1>
        <p class="text-gray-600 mt-2">Jadwal lengkap mata pelajaran semua kelas</p>
    </div>

    <!-- Filter -->
    <x-card class="mb-6">
        <form method="GET" action="{{ url('/jadwal') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Kelas</label>
                <select name="class" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
                    <option value="">Semua Kelas</option>
                    @foreach($classes as $class)
                        <option value="{{ $class->id }}" {{ request('class') == $class->id ? 'selected' : '' }}>
                            {{ $class->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Hari</label>
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

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Mata Pelajaran</label>
                <input type="text" name="subject" value="{{ request('subject') }}" 
                       placeholder="Cari mata pelajaran..."
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
            </div>

            <div class="flex items-end">
                <x-button type="submit" variant="primary" class="w-full">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                    </svg>
                    Filter
                </x-button>
            </div>
        </form>
    </x-card>

    <!-- Schedule View Toggle -->
    <div class="flex justify-end mb-4">
        <div class="inline-flex rounded-lg border border-gray-300 bg-white">
            <button onclick="showTableView()" id="tableViewBtn" 
                    class="px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-l-lg border-r">
                <svg class="w-5 h-5 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                </svg>
                List
            </button>
            <button onclick="showCalendarView()" id="calendarViewBtn"
                    class="px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-r-lg">
                <svg class="w-5 h-5 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                Kalender
            </button>
        </div>
    </div>

    <!-- Table View -->
    <div id="tableView">
        <x-card>
            @if($schedules->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gray-100 border-b border-gray-200">
                                <th class="text-left p-4 font-semibold text-gray-700">Hari</th>
                                <th class="text-left p-4 font-semibold text-gray-700">Waktu</th>
                                <th class="text-left p-4 font-semibold text-gray-700">Mata Pelajaran</th>
                                <th class="text-left p-4 font-semibold text-gray-700">Kelas</th>
                                <th class="text-left p-4 font-semibold text-gray-700">Guru</th>
                                <th class="text-left p-4 font-semibold text-gray-700">Ruangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($schedules as $schedule)
                                <tr class="border-b border-gray-200 hover:bg-gray-50 transition-colors">
                                    <td class="p-4">
                                        <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded text-sm font-medium">
                                            {{ $schedule->day }}
                                        </span>
                                    </td>
                                    <td class="p-4 text-gray-700">
                                        <div class="font-medium">{{ $schedule->start_time->format('H:i') }} - {{ $schedule->end_time->format('H:i') }}</div>
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
                                    <td class="p-4 text-gray-700">{{ $schedule->teacher->name }}</td>
                                    <td class="p-4">
                                        <span class="px-2 py-1 bg-green-100 text-green-700 rounded text-sm">
                                            {{ $schedule->room }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-4">
                    {{ $schedules->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <h3 class="text-lg font-semibold text-gray-700 mb-2">Tidak ada jadwal</h3>
                    <p class="text-gray-500">Belum ada jadwal yang sesuai dengan filter</p>
                </div>
            @endif
        </x-card>
    </div>

    <!-- Calendar View -->
    <div id="calendarView" class="hidden">
        <div class="grid grid-cols-1 gap-6">
            @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'] as $day)
                @php
                    $daySchedules = $schedules->where('day', $day);
                @endphp
                @if($daySchedules->count() > 0)
                    <x-card>
                        <h3 class="text-lg font-bold text-gray-800 mb-4 pb-2 border-b">{{ $day }}</h3>
                        <div class="space-y-3">
                            @foreach($daySchedules as $schedule)
                                <div class="flex items-center p-3 bg-gray-50 rounded-lg border border-gray-200 hover:shadow-md transition">
                                    <div class="flex-shrink-0 w-20 h-20 bg-blue-500 text-white rounded-lg flex flex-col items-center justify-center">
                                        <span class="text-xs font-medium">{{ $schedule->schoolClass?->name ?? 'Tidak ada kelas' }}</span>
                                        <span class="text-lg font-bold">{{ $schedule->start_time->format('H:i') }}</span>
                                    </div>
                                    <div class="ml-4 flex-1">
                                        <h4 class="font-bold text-gray-800">{{ $schedule->subject->name }}</h4>
                                        <p class="text-sm text-gray-600">{{ $schedule->teacher->name }}</p>
                                        <p class="text-xs text-gray-500 mt-1">{{ $schedule->room }} • {{ $schedule->time_range }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </x-card>
                @endif
            @endforeach
        </div>
    </div>

</div>

@push('scripts')
<script>
    function showTableView() {
        document.getElementById('tableView').classList.remove('hidden');
        document.getElementById('calendarView').classList.add('hidden');
        document.getElementById('tableViewBtn').classList.add('bg-blue-50', 'text-blue-600');
        document.getElementById('calendarViewBtn').classList.remove('bg-blue-50', 'text-blue-600');
    }

    function showCalendarView() {
        document.getElementById('tableView').classList.add('hidden');
        document.getElementById('calendarView').classList.remove('hidden');
        document.getElementById('calendarViewBtn').classList.add('bg-blue-50', 'text-blue-600');
        document.getElementById('tableViewBtn').classList.remove('bg-blue-50', 'text-blue-600');
    }

    // Default to table view
    showTableView();
</script>
@endpush
@endsection