<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SIAKAD SMP') }} - @yield('title')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Alpine.js untuk interaktivitas -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @stack('styles')
</head>
<body class="bg-gray-50 font-sans antialiased">
    <div class="min-h-screen">
        <!-- Navigation -->
        <nav class="bg-gradient-to-r from-blue-600 to-blue-800 shadow-lg" x-data="{ open: false }">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <!-- Logo & Brand -->
                    <div class="flex items-center">
                        <a href="{{ url('/') }}" class="flex items-center space-x-3">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                            <div class="text-white">
                                <div class="text-xl font-bold">SIAKAD SMP</div>
                                <div class="text-xs text-blue-100">Sistem Informasi Akademik</div>
                            </div>
                        </a>
                    </div>

                    <!-- Desktop Navigation -->
                    <div class="hidden md:flex md:items-center md:space-x-1">
                        <a href="{{ url('/dashboard') }}" class="px-4 py-2 text-white hover:bg-blue-700 rounded-lg transition duration-150 {{ request()->is('dashboard') ? 'bg-blue-700' : '' }}">
                            Dashboard
                        </a>
                        <a href="{{ url('/jadwal') }}" class="px-4 py-2 text-white hover:bg-blue-700 rounded-lg transition duration-150 {{ request()->is('jadwal*') ? 'bg-blue-700' : '' }}">
                            Jadwal
                        </a>
                        <a href="{{ url('/mata-pelajaran') }}" class="px-4 py-2 text-white hover:bg-blue-700 rounded-lg transition duration-150 {{ request()->is('mata-pelajaran*') ? 'bg-blue-700' : '' }}">
                            Mata Pelajaran
                        </a>
                        <a href="{{ url('/registrasi') }}" class="px-4 py-2 text-white hover:bg-blue-700 rounded-lg transition duration-150 {{ request()->is('registrasi*') ? 'bg-blue-700' : '' }}">
                            Registrasi
                        </a>
                        <a href="{{ url('/kelas') }}" class="px-4 py-2 text-white hover:bg-blue-700 rounded-lg transition duration-150 {{ request()->is('kelas*') ? 'bg-blue-700' : '' }}">
                            Kelas
                        </a>
                        @if(Auth::check() && Auth::user()->isAdmin())
                            <a href="{{ url('/admin/dashboard') }}" class="px-4 py-2 text-white bg-yellow-500 hover:bg-yellow-600 rounded-lg transition duration-150 {{ request()->is('admin*') ? 'bg-yellow-600' : '' }}">
                                Admin Panel
                            </a>
                        @endif
                    </div>

                    <!-- User Menu -->
                    <div class="hidden md:flex md:items-center md:space-x-4">
                        @auth
                            <div x-data="{ userMenu: false }" class="relative">
                                <button @click="userMenu = !userMenu" class="flex items-center space-x-2 text-white hover:text-blue-100 transition">
                                    <span class="text-sm font-medium">{{ Auth::user()->name ?? 'User' }}</span>
                                    <div class="w-9 h-9 bg-blue-500 rounded-full flex items-center justify-center">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>

                                <div x-show="userMenu" @click.away="userMenu = false" 
                                     x-transition:enter="transition ease-out duration-200"
                                     x-transition:enter-start="opacity-0 scale-95"
                                     x-transition:enter-end="opacity-100 scale-100"
                                     x-transition:leave="transition ease-in duration-150"
                                     x-transition:leave-start="opacity-100 scale-100"
                                     x-transition:leave-end="opacity-0 scale-95"
                                     class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-1 z-50">
                                    <a href="{{ url('/profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                                    <a href="{{ url('/settings') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Settings</a>
                                    <hr class="my-1">
                                    <form method="POST" action="{{ url('/logout') }}">
                                        @csrf
                                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                                            Logout
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @else
                            <a href="{{ url('/login') }}" class="px-4 py-2 text-white hover:text-blue-100 transition">Login</a>
                            <a href="{{ url('/register') }}" class="px-4 py-2 bg-white text-blue-600 rounded-lg hover:bg-blue-50 transition font-medium">Register</a>
                        @endauth
                    </div>

                    <!-- Mobile menu button -->
                    <div class="flex items-center md:hidden">
                        <button @click="open = !open" class="text-white hover:text-blue-100 focus:outline-none">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                <path x-show="open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobile Navigation -->
            <div x-show="open" x-transition class="md:hidden bg-blue-700">
                <div class="px-2 pt-2 pb-3 space-y-1">
                    <a href="{{ url('/dashboard') }}" class="block px-3 py-2 text-white hover:bg-blue-600 rounded-lg">Dashboard</a>
                    <a href="{{ url('/jadwal') }}" class="block px-3 py-2 text-white hover:bg-blue-600 rounded-lg">Jadwal</a>
                    <a href="{{ url('/mata-pelajaran') }}" class="block px-3 py-2 text-white hover:bg-blue-600 rounded-lg">Mata Pelajaran</a>
                    <a href="{{ url('/registrasi') }}" class="block px-3 py-2 text-white hover:bg-blue-600 rounded-lg">Registrasi</a>
                    <a href="{{ url('/kelas') }}" class="block px-3 py-2 text-white hover:bg-blue-600 rounded-lg">Kelas</a>
                    @guest
                        <a href="{{ url('/login') }}" class="block px-3 py-2 text-white hover:bg-blue-600 rounded-lg">Login</a>
                        <a href="{{ url('/register') }}" class="block px-3 py-2 text-white hover:bg-blue-600 rounded-lg">Register</a>
                    @endguest
                </div>
            </div>
        </nav>

        <!-- Flash Messages -->
        @if(session('success'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                <x-alert type="success" :message="session('success')" />
            </div>
        @endif

        @if(session('error'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                <x-alert type="error" :message="session('error')" />
            </div>
        @endif

        <!-- Page Content -->
        <main class="py-8">
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t border-gray-200 mt-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <div class="text-center text-gray-500 text-sm">
                    &copy; {{ date('Y') }} SIAKAD SMP. All rights reserved.
                </div>
            </div>
        </footer>
    </div>

    @stack('scripts')
</body>
</html>