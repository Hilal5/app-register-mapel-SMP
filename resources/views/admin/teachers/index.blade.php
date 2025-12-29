@extends('layouts.app')

@section('title', 'Kelola Guru')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    
    <!-- Page Header -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Kelola Guru</h1>
            <p class="text-gray-600 mt-2">Manajemen data guru pengajar</p>
        </div>
        <x-button href="{{ url('/admin/teachers/create') }}" variant="primary">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Guru
        </x-button>
    </div>

    @if(session('success'))
        <x-alert type="success" :message="session('success')" class="mb-6" />
    @endif
    @if(session('error'))
        <x-alert type="error" :message="session('error')" class="mb-6" />
    @endif

    <!-- Teachers Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
        @forelse($teachers as $teacher)
            <x-card hover="true">
                <div class="flex items-start justify-between mb-4">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-blue-500 text-white rounded-full flex items-center justify-center font-bold text-lg">
                            {{ substr($teacher->name, 0, 1) }}
                        </div>
                        <div class="ml-3">
                            <h3 class="font-bold text-gray-800">{{ $teacher->name }}</h3>
                            <p class="text-xs text-gray-500">NIP: {{ $teacher->nip }}</p>
                        </div>
                    </div>
                    @if($teacher->status == 'active')
                        <span class="px-2 py-1 bg-green-100 text-green-700 rounded text-xs">Aktif</span>
                    @else
                        <span class="px-2 py-1 bg-gray-100 text-gray-700 rounded text-xs">Nonaktif</span>
                    @endif
                </div>

                <div class="space-y-2 mb-4 text-sm">
                    <div class="flex items-center text-gray-600">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        {{ $teacher->email }}
                    </div>
                    @if($teacher->phone)
                        <div class="flex items-center text-gray-600">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            {{ $teacher->phone }}
                        </div>
                    @endif
                    <div class="flex items-center text-gray-600">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        {{ $teacher->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}
                    </div>
                </div>

                <div class="flex gap-2 pt-4 border-t">
                    <x-button href="{{ url('/admin/teachers/' . $teacher->id . '/edit') }}" variant="outline" size="sm" class="flex-1">
                        Edit
                    </x-button>
                    <form method="POST" action="{{ url('/admin/teachers/' . $teacher->id) }}" 
                          onsubmit="return confirm('Yakin ingin menghapus guru ini?')" class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full px-3 py-1.5 text-sm bg-red-600 text-white rounded-lg hover:bg-red-700">
                            Hapus
                        </button>
                    </form>
                </div>
            </x-card>
        @empty
            <div class="col-span-3">
                <x-card>
                    <div class="text-center py-12">
                        <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <h3 class="text-lg font-semibold text-gray-700 mb-2">Belum ada guru</h3>
                        <p class="text-gray-500">Tambahkan guru baru untuk memulai</p>
                    </div>
                </x-card>
            </div>
        @endforelse
    </div>

    @if($teachers->hasPages())
        <div class="mt-6">
            {{ $teachers->links() }}
        </div>
    @endif

</div>
@endsection