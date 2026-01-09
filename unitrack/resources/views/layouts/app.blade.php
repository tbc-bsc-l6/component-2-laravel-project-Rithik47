<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'UniTrack') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        // On page load or when changing themes, best to add inline in `head` to avoid FOUC
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark')
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>
</head>
<body class="bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 h-full transition-colors duration-300 relative overflow-x-hidden">

    <!-- Global Background Gradients -->
    <div class="fixed inset-0 z-0 pointer-events-none">
        <div class="absolute top-0 left-1/4 w-96 h-96 bg-indigo-500/10 rounded-full blur-3xl mix-blend-multiply dark:mix-blend-screen opacity-50 animate-blob"></div>
        <div class="absolute top-1/3 right-1/4 w-96 h-96 bg-purple-500/10 rounded-full blur-3xl mix-blend-multiply dark:mix-blend-screen opacity-50 animate-blob animation-delay-2000"></div>
        <div class="absolute -bottom-32 left-1/3 w-96 h-96 bg-pink-500/10 rounded-full blur-3xl mix-blend-multiply dark:mix-blend-screen opacity-50 animate-blob animation-delay-4000"></div>
    </div>

    <div class="relative z-10 flex flex-col min-h-screen" x-data="{ mobileMenuOpen: false, darkMode: localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches) }">
        
        <!-- Sticky Glass Nav -->
        <nav class="sticky top-0 z-50 w-full border-b border-white/20 dark:border-gray-700/50 bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl supports-[backdrop-filter]:bg-white/60 dark:supports-[backdrop-filter]:bg-gray-900/60">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16 items-center">
                    
                    <!-- Logo & Desktop Nav -->
                    <div class="flex items-center gap-8">
                        <a href="{{ route('dashboard') }}" class="flex items-center gap-2 group">
                            <div class="relative flex items-center justify-center w-10 h-10 rounded-xl bg-white/10 dark:bg-white/10 backdrop-blur-md border border-white/20 dark:border-white/20 shadow-lg group-hover:scale-105 transition-transform duration-200 overflow-hidden">
                                <x-application-logo class="w-7 h-7 object-contain" />
                            </div>
                            <span class="font-bold text-xl tracking-tight bg-clip-text text-transparent bg-gradient-to-r from-gray-900 to-gray-600 dark:from-white dark:to-gray-300">UniTrack</span>
                        </a>

                        <div class="hidden md:flex items-center space-x-1">
                            <a href="{{ route('modules.index') }}" class="px-3 py-2 rounded-lg text-sm font-medium text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-white/5 hover:text-indigo-600 dark:hover:text-white transition-all">
                                Browse Modules
                            </a>
                            @auth
                                @if(auth()->user()->isAdmin())
                                    <a href="{{ route('admin.modules.index') }}" class="px-3 py-2 rounded-lg text-sm font-medium text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-white/5 hover:text-indigo-600 dark:hover:text-white transition-all">
                                        Manage Modules
                                    </a>
                                    <a href="{{ route('admin.users.index') }}" class="px-3 py-2 rounded-lg text-sm font-medium text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-white/5 hover:text-indigo-600 dark:hover:text-white transition-all">
                                        Users
                                    </a>
                                @endif
                                @if(auth()->user()->role === 'teacher')
                                    <a href="{{ route('teacher.modules.index') }}" class="px-3 py-2 rounded-lg text-sm font-medium text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-white/5 hover:text-indigo-600 dark:hover:text-white transition-all">
                                        My Modules
                                    </a>
                                @endif
                            @endauth
                        </div>
                    </div>

                    <!-- Right Side Actions -->
                    <div class="flex items-center gap-4">
                        <!-- Dark Mode Toggle -->
                        <button 
                            @click="darkMode = !darkMode; localStorage.theme = darkMode ? 'dark' : 'light'; if (darkMode) document.documentElement.classList.add('dark'); else document.documentElement.classList.remove('dark');"
                            class="p-2 rounded-lg text-gray-500 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-white/5 transition-colors focus:outline-none"
                            title="Toggle Dark Mode"
                        >
                            <!-- Sun -->
                            <svg x-show="!darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            <!-- Moon -->
                            <svg x-show="darkMode" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
                        </button>

                        @auth
                            <!-- Profile Dropdown -->
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" class="flex items-center gap-3 pl-3 pr-2 py-1.5 rounded-full hover:bg-gray-50 dark:hover:bg-white/5 border border-transparent hover:border-gray-200 dark:hover:border-white/10 transition-all group">
                                    <div class="text-right hidden sm:block">
                                        <div class="text-xs font-medium text-gray-500 dark:text-gray-400 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors uppercase tracking-wider">{{ auth()->user()->role }}</div>
                                        <div class="text-sm font-semibold text-gray-700 dark:text-gray-200">{{ auth()->user()->name }}</div>
                                    </div>
                                    <div class="relative">
                                        <div class="w-9 h-9 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold text-sm shadow-md ring-2 ring-white dark:ring-gray-800">
                                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                        </div>
                                        <div class="absolute bottom-0 right-0 w-2.5 h-2.5 rounded-full border-2 border-white dark:border-gray-800 bg-green-500"></div>
                                    </div>
                                </button>

                                <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute right-0 mt-2 w-56 rounded-xl bg-white dark:bg-gray-800 shadow-xl border border-gray-100 dark:border-gray-700 py-2 origin-top-right focus:outline-none z-50">
                                    <div class="px-4 py-3 border-b border-gray-100 dark:border-gray-700/50">
                                        <p class="text-sm text-gray-900 dark:text-white font-medium">Signed in as</p>
                                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">{{ auth()->user()->email }}</p>
                                    </div>
                                    
                                    <div class="py-1">
                                        <a href="{{ route('profile.edit') }}" class="group flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-white/5 hover:text-indigo-600 dark:hover:text-indigo-400">
                                            <svg class="mr-3 h-5 w-5 text-gray-400 group-hover:text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                            Profile Settings
                                        </a>
                                        @if(in_array(auth()->user()->role, ['user', 'old_student']))
                                            <a href="{{ route('student.dashboard') }}" class="group flex items-center px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-white/5 hover:text-indigo-600 dark:hover:text-indigo-400">
                                                <svg class="mr-3 h-5 w-5 text-gray-400 group-hover:text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                                                My Dashboard
                                            </a>
                                        @endif
                                    </div>
                                    
                                    <div class="py-1 border-t border-gray-100 dark:border-gray-700/50">
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="group flex w-full items-center px-4 py-2 text-sm text-red-600 hover:bg-red-50 dark:hover:bg-red-900/10">
                                                <svg class="mr-3 h-5 w-5 text-red-400 group-hover:text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                                Sign out
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="flex items-center gap-2">
                                <a href="{{ route('login') }}" class="text-sm font-semibold text-gray-600 dark:text-gray-300 hover:text-indigo-600 dark:hover:text-white px-3 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-white/5 transition-all">Sign in</a>
                                <a href="{{ route('register') }}" class="text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-500 px-4 py-2 rounded-lg shadow-lg shadow-indigo-500/20 transition-all transform hover:-translate-y-0.5">Get Started</a>
                            </div>
                        @endauth

                        <!-- Mobile Menu Button -->
                        <div class="md:hidden flex items-center">
                            <button @click="mobileMenuOpen = !mobileMenuOpen" class="p-2 rounded-lg text-gray-500 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-white/5 transition-colors focus:outline-none">
                                <svg x-show="!mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                                <svg x-show="mobileMenuOpen" x-cloak class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div x-show="mobileMenuOpen" x-cloak class="md:hidden border-t border-gray-100 dark:border-gray-700/50 bg-white dark:bg-gray-900 shadow-xl">
                 <div class="px-4 py-3 space-y-1">
                    <a href="{{ route('modules.index') }}" class="block px-3 py-2 rounded-lg text-base font-medium text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-white/5 hover:text-indigo-600 dark:hover:text-white">Browse Modules</a>
                    @auth
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.modules.index') }}" class="block px-3 py-2 rounded-lg text-base font-medium text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-white/5 hover:text-indigo-600 dark:hover:text-white">Manage Modules</a>
                            <a href="{{ route('admin.users.index') }}" class="block px-3 py-2 rounded-lg text-base font-medium text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-white/5 hover:text-indigo-600 dark:hover:text-white">Users</a>
                        @endif
                        <div class="border-t border-gray-100 dark:border-gray-700/50 my-2 pt-2">
                             <a href="{{ route('profile.edit') }}" class="block px-3 py-2 rounded-lg text-base font-medium text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-white/5 hover:text-indigo-600 dark:hover:text-white">My Profile</a>
                             <form method="POST" action="{{ route('logout') }}" class="mt-1">
                                @csrf
                                <button type="submit" class="block w-full text-left px-3 py-2 rounded-lg text-base font-medium text-red-600 hover:bg-red-50 dark:hover:bg-red-900/10">Sign out</button>
                            </form>
                        </div>
                    @endauth
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="flex-grow max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8 relative">
            @if(session('success'))
                <div x-data="{show: true}" x-show="show" x-init="setTimeout(()=> show = false, 4000)" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2" class="mb-6 rounded-xl bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 text-green-800 dark:text-green-300 px-4 py-3 shadow-sm flex items-center gap-3">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    {{ session('success') }}
                </div>
            @endif

             @if(session('error'))
                <div x-data="{show: true}" x-show="show" x-init="setTimeout(()=> show = false, 4000)" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2" class="mb-6 rounded-xl bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-300 px-4 py-3 shadow-sm flex items-center gap-3">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </main>

        <!-- Modern Footer -->
        <footer class="mt-auto relative z-10 border-t border-gray-200/50 dark:border-gray-800/50 bg-white/40 dark:bg-gray-900/40 backdrop-blur-md">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-12">
                    <!-- Brand Section -->
                    <div class="col-span-1 md:col-span-1">
                        <a href="{{ route('dashboard') }}" class="flex items-center gap-2 group mb-4">
                            <div class="relative flex items-center justify-center w-8 h-8 rounded-lg bg-white/10 dark:bg-white/10 backdrop-blur-md border border-white/20 dark:border-white/20 shadow-lg group-hover:scale-105 transition-transform duration-200 overflow-hidden">
                                <x-application-logo class="w-5 h-5 object-contain" />
                            </div>
                            <span class="font-bold text-lg tracking-tight bg-clip-text text-transparent bg-gradient-to-r from-gray-900 to-gray-600 dark:from-white dark:to-gray-300">UniTrack</span>
                        </a>
                        <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed">
                            Simplifying academic management with elegance and efficiency. Built for students and teachers alike.
                        </p>
                    </div>

                    <!-- Quick Links -->
                    <div>
                        <h4 class="text-sm font-semibold text-gray-900 dark:text-white uppercase tracking-wider mb-4">Navigation</h4>
                        <ul class="space-y-2">
                            <li><a href="{{ route('dashboard') }}" class="text-sm text-gray-500 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Dashboard</a></li>
                            <li><a href="{{ route('modules.index') }}" class="text-sm text-gray-500 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Browse Modules</a></li>
                            <li><a href="{{ route('profile.edit') }}" class="text-sm text-gray-500 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Profile Settings</a></li>
                        </ul>
                    </div>

                    <!-- Support -->
                    <div>
                        <h4 class="text-sm font-semibold text-gray-900 dark:text-white uppercase tracking-wider mb-4">Support</h4>
                        <ul class="space-y-2">
                            <li><a href="#" class="text-sm text-gray-500 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Help Center</a></li>
                            <li><a href="#" class="text-sm text-gray-500 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Privacy Policy</a></li>
                            <li><a href="#" class="text-sm text-gray-500 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Terms of Service</a></li>
                        </ul>
                    </div>

                    <!-- Contact -->
                    <div>
                        <h4 class="text-sm font-semibold text-gray-900 dark:text-white uppercase tracking-wider mb-4">Connect</h4>
                        <div class="flex space-x-4">
                            <a href="#" class="text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">
                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">
                                <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 .297c-6.63 0-12 5.373-12 12 0 5.303 3.438 9.8 8.205 11.385.6.113.82-.258.82-.577 0-.285-.01-1.04-.015-2.04-3.338.724-4.042-1.61-4.042-1.61C4.422 18.07 3.633 17.7 3.633 17.7c-1.087-.744.084-.729.084-.729 1.205.084 1.838 1.236 1.838 1.236 1.07 1.835 2.809 1.305 3.495.998.108-.776.417-1.305.76-1.605-2.665-.3-5.466-1.332-5.466-5.93 0-1.31.465-2.38 1.235-3.22-.135-.303-.54-1.523.105-3.176 0 0 1.005-.322 3.3 1.23.96-.267 1.98-.399 3-.405 1.02.006 2.04.138 3 .405 2.28-1.552 3.285-1.23 3.285-1.23.645 1.653.24 2.873.12 3.176.765.84 1.23 1.91 1.23 3.22 0 4.61-2.805 5.625-5.475 5.92.42.36.81 1.096.81 2.22 0 1.606-.015 2.896-.015 3.286 0 .315.21.69.825.57C20.565 22.092 24 17.592 24 12.297c0-6.627-5.373-12-12-12"/></svg>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="mt-12 pt-8 border-t border-gray-200/50 dark:border-gray-800/50 text-center">
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        &copy; {{ date('Y') }} Unitrack, Inc. All rights reserved. Built with elegance for the academic future.
                    </p>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>
