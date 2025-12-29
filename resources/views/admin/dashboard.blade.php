@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Admin Dashboard</h1>
        <p class="text-gray-600 mt-2">Selamat datang, {{ Auth::user()->name }}</p>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <x-card hover="true" class="bg-gradient-to-br from-blue-500 to-blue-600 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm">Total Siswa</p>
                    <h3 class="text-3xl font-bold mt-2">{{ $stats['totalStudents'] }}</h3>
                </div>
                <svg class="w-12 h-12 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            </div>
        </x-card>

        <x-card hover="true" class="bg-gradient-to-br from-green-500 to-green-600 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm">Total Guru</p>
                    <h3 class="text-3xl font-bold mt-2">{{ $stats['totalTeachers'] }}</h3>
                </div>
                <svg class="w-12 h-12 text-green-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
        </x-card>

        <x-card hover="true" class="bg-gradient-to-br from-purple-500 to-purple-600 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm">Mata Pelajaran</p>
                    <h3 class="text-3xl font-bold mt-2">{{ $stats['totalSubjects'] }}</h3>
                </div>
                <svg class="w-12 h-12 text-purple-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
            </div>
        </x-card>

        <x-card hover="true" class="bg-gradient-to-br from-orange-500 to-orange-600 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-orange-100 text-sm">Registrasi Pending</p>
                    <h3 class="text-3xl font-bold mt-2">{{ $stats['pendingRegistrations'] }}</h3>
                </div>
                <svg class="w-12 h-12 text-orange-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
        </x-card>
    </div>

    <!-- Quick Actions -->
    <x-card title="Quick Actions" class="mb-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <x-button href="{{ route('admin.subjects.create') }}" variant="primary" class="w-full">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Mapel
            </x-button>

            <x-button href="{{ route('admin.teachers.create') }}" variant="success" class="w-full">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Guru
            </x-button>

            <x-button href="{{ route('admin.schedules.create') }}" variant="outline" class="w-full">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Jadwal
            </x-button>

            <x-button href="{{ route('admin.registrations.index') }}" variant="warning" class="w-full">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Kelola Registrasi
            </x-button>
        </div>
    </x-card>

    <!-- Content Grid - 2 Columns Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        
        <!-- Recent Registrations -->
        <x-card title="Registrasi Terbaru" subtitle="5 registrasi terakhir">
            @if($recentRegistrations->count() > 0)
                <div class="space-y-3">
                    @foreach($recentRegistrations as $reg)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg border border-gray-200">
                            <div class="flex-1">
                                <h4 class="font-semibold text-gray-800">{{ $reg->user->name }}</h4>
                                <p class="text-sm text-gray-600">{{ $reg->subject->name }}</p>
                                <p class="text-xs text-gray-500">{{ $reg->created_at->diffForHumans() }}</p>
                            </div>
                            <div>
                                @if($reg->status == 'approved')
                                    <span class="px-2 py-1 bg-green-100 text-green-700 rounded text-xs">Approved</span>
                                @elseif($reg->status == 'pending')
                                    <span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded text-xs">Pending</span>
                                @else
                                    <span class="px-2 py-1 bg-red-100 text-red-700 rounded text-xs">{{ $reg->status }}</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-4">
                    <x-button href="{{ route('admin.registrations.index') }}" variant="outline" size="sm" class="w-full">
                        Lihat Semua
                    </x-button>
                </div>
            @else
                <p class="text-gray-500 text-center py-4">Belum ada registrasi</p>
            @endif
        </x-card>

        <!-- Recent Students -->
        <x-card title="Siswa Terbaru" subtitle="5 siswa terakhir mendaftar">
            @if($recentStudents->count() > 0)
                <div class="space-y-3">
                    @foreach($recentStudents as $student)
                        <div class="flex items-center p-3 bg-gray-50 rounded-lg border border-gray-200">
                            <div class="w-10 h-10 bg-blue-500 text-white rounded-full flex items-center justify-center font-bold">
                                {{ substr($student->name, 0, 1) }}
                            </div>
                            <div class="ml-3 flex-1">
                                <h4 class="font-semibold text-gray-800">{{ $student->name }}</h4>
                                <p class="text-sm text-gray-600">{{ $student->email }}</p>
                                <p class="text-xs text-gray-500">NIS: {{ $student->nis }}</p>
                            </div>
                            <div class="text-right">
                                @if($student->class)
                                    <span class="px-2 py-1 bg-purple-100 text-purple-700 rounded text-xs">
                                        {{ $student->class->name }}
                                    </span>
                                @else
                                    <span class="text-xs text-gray-400">Belum ada kelas</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-4">
                    <x-button href="{{ route('admin.students.index') }}" variant="outline" size="sm" class="w-full">
                        Lihat Semua
                    </x-button>
                </div>
            @else
                <p class="text-gray-500 text-center py-4">Belum ada siswa</p>
            @endif
        </x-card>

    </div>

    <!-- New 3 Columns Layout for Schedules, Subjects, Teachers -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Recent Schedules -->
        <x-card title="Jadwal Terbaru" subtitle="5 jadwal terakhir">
            @if($recentSchedules->count() > 0)
                <div class="space-y-3">
                    @foreach($recentSchedules as $schedule)
                        <div class="p-3 bg-gray-50 rounded-lg border border-gray-200">
                            <div class="flex items-start justify-between mb-2">
                                <h4 class="font-semibold text-gray-800 text-sm">{{ $schedule->subject->name }}</h4>
                                <span class="px-2 py-1 bg-indigo-100 text-indigo-700 rounded text-xs">
                                    {{ $schedule->day }}
                                </span>
                            </div>
                            <p class="text-xs text-gray-600">Guru: {{ $schedule->teacher->name }}</p>
                            <p class="text-xs text-gray-600">Kelas: {{ $schedule->schoolClass->name }}</p>
                            <p class="text-xs text-gray-500">{{ $schedule->start_time }} - {{ $schedule->end_time }}</p>
                        </div>
                    @endforeach
                </div>
                <div class="mt-4">
                    <x-button href="{{ route('admin.schedules.index') }}" variant="outline" size="sm" class="w-full">
                        Lihat Semua
                    </x-button>
                </div>
            @else
                <p class="text-gray-500 text-center py-4">Belum ada jadwal</p>
            @endif
        </x-card>

        <!-- Recent Subjects -->
        <x-card title="Mata Pelajaran" subtitle="5 mata pelajaran terakhir">
            @if($recentSubjects->count() > 0)
                <div class="space-y-3">
                    @foreach($recentSubjects as $subject)
                        <div class="p-3 bg-gray-50 rounded-lg border border-gray-200">
                            <div class="flex items-start justify-between">
                                <div class="flex-1">
                                    <h4 class="font-semibold text-gray-800 text-sm">{{ $subject->name }}</h4>
                                    <p class="text-xs text-gray-600 mt-1">{{ $subject->code }}</p>
                                    @if($subject->description)
                                        <p class="text-xs text-gray-500 mt-1 line-clamp-2">{{ Str::limit($subject->description, 60) }}</p>
                                    @endif
                                </div>
                                <span class="px-2 py-1 bg-green-100 text-green-700 rounded text-xs ml-2">
                                    {{ $subject->credits }} SKS
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-4">
                    <x-button href="{{ route('admin.subjects.index') }}" variant="outline" size="sm" class="w-full">
                        Lihat Semua
                    </x-button>
                </div>
            @else
                <p class="text-gray-500 text-center py-4">Belum ada mata pelajaran</p>
            @endif
        </x-card>

        <!-- Recent Teachers -->
        <x-card title="Guru Terbaru" subtitle="5 guru terakhir">
            @if($recentTeachers->count() > 0)
                <div class="space-y-3">
                    @foreach($recentTeachers as $teacher)
                        <div class="flex items-center p-3 bg-gray-50 rounded-lg border border-gray-200">
                            <div class="w-10 h-10 bg-green-500 text-white rounded-full flex items-center justify-center font-bold">
                                {{ substr($teacher->name, 0, 1) }}
                            </div>
                            <div class="ml-3 flex-1">
                                <h4 class="font-semibold text-gray-800 text-sm">{{ $teacher->name }}</h4>
                                <p class="text-xs text-gray-600">{{ $teacher->email }}</p>
                                @if($teacher->phone)
                                    <p class="text-xs text-gray-500">{{ $teacher->phone }}</p>
                                @endif
                            </div>
                            <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded text-xs">
                                {{ $teacher->status }}
                            </span>
                        </div>
                    @endforeach
                </div>
                <div class="mt-4">
                    <x-button href="{{ route('admin.teachers.index') }}" variant="outline" size="sm" class="w-full">
                        Lihat Semua
                    </x-button>
                </div>
            @else
                <p class="text-gray-500 text-center py-4">Belum ada guru</p>
            @endif
        </x-card>

    </div>

</div>
@endsection