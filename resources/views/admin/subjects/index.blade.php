@extends('layouts.app')

@section('title', 'Kelola Mata Pelajaran')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    
    <!-- Page Header -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Kelola Mata Pelajaran</h1>
            <p class="text-gray-600 mt-2">Manajemen data mata pelajaran</p>
        </div>
        <x-button href="{{ url('/admin/subjects/create') }}" variant="primary">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Mata Pelajaran
        </x-button>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
        <x-alert type="success" :message="session('success')" class="mb-6" />
    @endif

    @if(session('error'))
        <x-alert type="error" :message="session('error')" class="mb-6" />
    @endif

    <!-- Subjects Table -->
    <x-card>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-100 border-b border-gray-200">
                        <th class="text-left p-4 font-semibold text-gray-700">Kode</th>
                        <th class="text-left p-4 font-semibold text-gray-700">Nama Mata Pelajaran</th>
                        <th class="text-left p-4 font-semibold text-gray-700">Guru Pengampu</th>
                        <th class="text-left p-4 font-semibold text-gray-700">SKS</th>
                        <th class="text-left p-4 font-semibold text-gray-700">Semester</th>
                        <th class="text-left p-4 font-semibold text-gray-700">Kuota</th>
                        <th class="text-left p-4 font-semibold text-gray-700">Status</th>
                        <th class="text-left p-4 font-semibold text-gray-700">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($subjects as $subject)
                        <tr class="border-b border-gray-200 hover:bg-gray-50 transition-colors">
                            <td class="p-4">
                                <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded text-sm font-bold">
                                    {{ $subject->code }}
                                </span>
                            </td>
                            <td class="p-4">
                                <div class="font-semibold text-gray-800">{{ $subject->name }}</div>
                                <div class="text-xs text-gray-500">{{ Str::limit($subject->description, 50) }}</div>
                            </td>
                            <td class="p-4 text-gray-700">
                                {{ $subject->teacher->name ?? '-' }}
                            </td>
                            <td class="p-4 text-gray-700">{{ $subject->credits }}</td>
                            <td class="p-4">
                                <span class="px-2 py-1 bg-purple-100 text-purple-700 rounded text-xs capitalize">
                                    {{ $subject->semester }}
                                </span>
                            </td>
                            <td class="p-4 text-gray-700">{{ $subject->quota }}</td>
                            <td class="p-4">
                                @if($subject->status == 'active')
                                    <span class="px-2 py-1 bg-green-100 text-green-700 rounded text-xs font-medium">
                                        Aktif
                                    </span>
                                @else
                                    <span class="px-2 py-1 bg-gray-100 text-gray-700 rounded text-xs font-medium">
                                        Nonaktif
                                    </span>
                                @endif
                            </td>
                            <td class="p-4">
                                <div class="flex gap-2">
                                    <a href="{{ url('/admin/subjects/' . $subject->id . '/edit') }}" 
                                       class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                        Edit
                                    </a>
                                    <form method="POST" 
                                          action="{{ url('/admin/subjects/' . $subject->id) }}"
                                          onsubmit="return confirm('Yakin ingin menghapus mata pelajaran ini?')"
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
                                Belum ada data mata pelajaran
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($subjects->hasPages())
            <div class="mt-4 border-t pt-4">
                {{ $subjects->links() }}
            </div>
        @endif
    </x-card>

</div>
@endsection