@extends('layouts.app')

@section('title', $subject->name)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ url('/mata-pelajaran') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Kembali ke Daftar Mata Pelajaran
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Subject Header -->
            <x-card>
                <div class="flex items-start justify-between mb-4">
                    <div class="flex-1">
                        <div class="flex items-center mb-2">
                            <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-lg text-sm font-bold">
                                {{ $subject->code }}
                            </span>
                            <span class="ml-3 px-3 py-1 bg-gray-100 text-gray-700 rounded-lg text-sm">
                                {{ $subject->credits }} SKS
                            </span>
                            <span class="ml-3 px-3 py-1 bg-purple-100 text-purple-700 rounded-lg text-sm capitalize">
                                Semester {{ $subject->semester }}
                            </span>
                        </div>
                        <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $subject->name }}</h1>
                        <p class="text-gray-600">{{ $subject->description }}</p>
                    </div>
                    
                    @if($subject->isQuotaFull())
                        <span class="px-4 py-2 bg-red-100 text-red-700 rounded-lg text-sm font-medium">
                            Kuota Penuh
                        </span>
                    @else
                        <span class="px-4 py-2 bg-green-100 text-green-700 rounded-lg text-sm font-medium">
                            Tersedia
                        </span>
                    @endif
                </div>

                <!-- Teacher Info -->
                <div class="border-t pt-4">
                    <h3 class="text-sm font-semibold text-gray-700 mb-3">Guru Pengampu</h3>
                    @if($subject->teacher)
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-blue-500 text-white rounded-full flex items-center justify-center font-bold text-lg">
                                {{ substr($subject->teacher->name, 0, 1) }}
                            </div>
                            <div class="ml-4">
                                <p class="font-semibold text-gray-800">{{ $subject->teacher->name }}</p>
                                <p class="text-sm text-gray-600">{{ $subject->teacher->email }}</p>
                            </div>
                        </div>
                    @else
                        <p class="text-gray-500 italic">Belum ada guru pengampu</p>
                    @endif
                </div>
            </x-card>

            <!-- Jadwal -->
            <x-card title="Jadwal Pelajaran">
                @if($subject->schedules->count() > 0)
                    <div class="space-y-3">
                        @foreach($subject->schedules as $schedule)
                            <div class="flex items-center p-4 bg-gray-50 rounded-lg border border-gray-200">
                                <div class="flex-shrink-0">
                                    <div class="w-16 h-16 bg-blue-500 text-white rounded-lg flex flex-col items-center justify-center">
                                        <span class="text-xs font-medium">{{ $schedule->day }}</span>
                                        <span class="text-sm font-bold">{{ $schedule->start_time->format('H:i') }}</span>
                                    </div>
                                </div>
                                <div class="ml-4 flex-1">
                                    <h4 class="font-semibold text-gray-800">{{ $schedule->schoolClass->name }}</h4>
                                    <p class="text-sm text-gray-600">
                                        {{ $schedule->time_range }} • {{ $schedule->room }}
                                    </p>
                                </div>
                                <div class="text-right">
                                    <span class="text-sm text-gray-500">{{ $schedule->duration }} menit</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center py-4">Belum ada jadwal untuk mata pelajaran ini</p>
                @endif
            </x-card>

        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            
            <!-- Quick Stats -->
            <x-card title="Statistik">
                <div class="space-y-4">
                    <div>
                        <div class="flex justify-between text-sm mb-1">
                            <span class="text-gray-600">Kuota Pendaftar</span>
                            <span class="font-semibold">{{ $subject->registered_count }}/{{ $subject->quota }}</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="h-2 rounded-full {{ $subject->isQuotaFull() ? 'bg-red-500' : 'bg-green-500' }}"
                                 style="width: {{ ($subject->registered_count / $subject->quota) * 100 }}%">
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 border-t">
                        <div class="flex justify-between mb-2">
                            <span class="text-sm text-gray-600">Sisa Kuota</span>
                            <span class="text-sm font-bold {{ $subject->remaining_quota > 0 ? 'text-green-600' : 'text-red-600' }}">
                                {{ $subject->remaining_quota }}
                            </span>
                        </div>
                        <div class="flex justify-between mb-2">
                            <span class="text-sm text-gray-600">Total Jadwal</span>
                            <span class="text-sm font-bold text-gray-800">{{ $subject->schedules->count() }}</span>
                        </div>
                    </div>
                </div>
            </x-card>

            <!-- Action Buttons -->
            <x-card>
                <div class="space-y-3">
                    @if(!$subject->isQuotaFull())
                        <x-button href="{{ url('/registrasi?subject=' . $subject->id) }}" variant="primary" size="lg" class="w-full">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Daftar Sekarang
                        </x-button>
                    @else
                        <button disabled class="w-full px-6 py-3 bg-gray-300 text-gray-500 rounded-lg font-medium cursor-not-allowed">
                            Kuota Penuh
                        </button>
                    @endif

                    <x-button href="{{ url('/jadwal') }}" variant="outline" size="lg" class="w-full">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Lihat Jadwal Lengkap
                    </x-button>
                </div>
            </x-card>

        </div>

    </div>

</div>
@endsection