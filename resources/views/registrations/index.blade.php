@extends('layouts.app')

@section('title', 'Registrasi Mata Pelajaran')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Registrasi Mata Pelajaran</h1>
        <p class="text-gray-600 mt-2">Daftar mata pelajaran yang tersedia untuk registrasi</p>
    </div>

    <!-- My Registrations Link -->
    <div class="mb-6">
        <x-button href="{{ url('/registrasi/saya') }}" variant="outline">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
            </svg>
            Lihat Registrasi Saya
        </x-button>
    </div>

    <!-- Available Subjects -->
    @if($subjects->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($subjects as $subject)
                <x-card hover="true">
                    <!-- Status Badge -->
                    <div class="flex justify-between items-start mb-4">
                        <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded text-xs font-bold">
                            {{ $subject->code }}
                        </span>
                        @if($subject->isQuotaFull())
                            <span class="px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-medium">
                                Penuh
                            </span>
                        @else
                            <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-medium">
                                Tersedia
                            </span>
                        @endif
                    </div>

                    <!-- Subject Info -->
                    <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $subject->name }}</h3>
                    <p class="text-sm text-gray-600 mb-4 line-clamp-2">{{ $subject->description }}</p>

                    <!-- Teacher -->
                    <div class="flex items-center mb-4 pb-4 border-b">
                        <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        <span class="text-sm text-gray-700">{{ $subject->teacher->name ?? 'TBA' }}</span>
                    </div>

                    <!-- Schedule Info -->
                    @if($subject->schedules->count() > 0)
                        <div class="mb-4">
                            <h4 class="text-xs font-semibold text-gray-700 mb-2">Jadwal Tersedia:</h4>
                            <div class="space-y-2">
                                @foreach($subject->schedules->take(2) as $schedule)
                                    <div class="text-xs text-gray-600 flex items-center">
                                        <svg class="w-4 h-4 mr-1 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        {{ $schedule->day }}, {{ $schedule->time_range }} ({{ $schedule->schoolClass?->name ?? 'Tidak ada kelas' }})
                                    </div>
                                @endforeach
                                @if($subject->schedules->count() > 2)
                                    <p class="text-xs text-blue-600">+{{ $subject->schedules->count() - 2 }} jadwal lainnya</p>
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- Quota -->
                    <div class="mb-4">
                        <div class="flex justify-between text-sm mb-1">
                            <span class="text-gray-600">Kuota</span>
                            <span class="font-semibold {{ $subject->isQuotaFull() ? 'text-red-600' : 'text-green-600' }}">
                                {{ $subject->registered_count }}/{{ $subject->quota }}
                            </span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="h-2 rounded-full {{ $subject->isQuotaFull() ? 'bg-red-500' : 'bg-green-500' }}"
                                 style="width: {{ ($subject->registered_count / $subject->quota) * 100 }}%">
                            </div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <form method="POST" action="{{ url('/registrasi/daftar') }}" class="space-y-2">
                        @csrf
                        <input type="hidden" name="subject_id" value="{{ $subject->id }}">
                        
                        @if($subject->schedules->count() > 1)
                            <select name="schedule_id" required class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500">
                                <option value="">Pilih Jadwal</option>
                                @foreach($subject->schedules as $schedule)
                                    <option value="{{ $schedule->id }}">
                                        {{ $schedule->schoolClass->name }} - {{ $schedule->day }}, {{ $schedule->time_range }}
                                    </option>
                                @endforeach
                            </select>
                        @elseif($subject->schedules->count() == 1)
                            <input type="hidden" name="schedule_id" value="{{ $subject->schedules->first()->id }}">
                        @endif

                        <div class="flex gap-2">
                            <x-button href="{{ url('/mata-pelajaran/' . $subject->id) }}" variant="outline" size="sm" class="flex-1">
                                Detail
                            </x-button>
                            @if(!$subject->isQuotaFull() && $subject->schedules->count() > 0)
                                <x-button type="submit" variant="primary" size="sm" class="flex-1">
                                    Daftar
                                </x-button>
                            @else
                                <button type="button" disabled class="flex-1 px-4 py-2 bg-gray-300 text-gray-500 rounded-lg text-sm cursor-not-allowed">
                                    {{ $subject->isQuotaFull() ? 'Penuh' : 'No Schedule' }}
                                </button>
                            @endif
                        </div>
                    </form>
                </x-card>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $subjects->links() }}
        </div>
    @else
        <x-card>
            <div class="text-center py-12">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <h3 class="text-lg font-semibold text-gray-700 mb-2">Tidak ada mata pelajaran</h3>
                <p class="text-gray-500">Belum ada mata pelajaran yang tersedia untuk registrasi</p>
            </div>
        </x-card>
    @endif

</div>
@endsection