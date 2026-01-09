@extends('layouts.app')

@section('content')
    <div class="space-y-8">
        {{-- Welcome Intro Section --}}
        <div
            class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-indigo-600 to-purple-600 text-white shadow-xl">
            <div class="absolute inset-0 bg-white/10 dark:bg-black/10 backdrop-blur-sm"></div>
            <div class="relative max-w-7xl mx-auto px-6 py-12 sm:px-12 sm:py-16">
                <div class="md:flex md:items-center md:justify-between gap-8">
                    <div class="md:w-2/3">
                        <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold tracking-tight mb-4">
                            Welcome back, {{ explode(' ', $user->name)[0] }}!
                        </h1>
                        <p class="text-lg text-indigo-100 max-w-2xl mb-8 leading-relaxed">
                            @if($role === 'admin')
                                Manage your institution's modules, users, and enrollments from one central hub.
                            @elseif($role === 'teacher')
                                Track student progress, grade assignments, and manage your course modules.
                            @else
                                Stay on top of your studies. Track your progress and find new modules.
                            @endif
                        </p>

                        <div class="flex flex-wrap gap-3">
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-white/20 backdrop-blur-md border border-white/20">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                        clip-rule="evenodd" />
                                </svg>
                                {{ ucfirst($role) }} Account
                            </span>
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-white/20 backdrop-blur-md border border-white/20">
                                {{ date('l, F jS, Y') }}
                            </span>
                        </div>
                    </div>

                    {{-- Hero Illustration/Icon Area --}}
                    <div class="hidden md:block md:w-1/3 text-right opacity-90">
                        <svg class="h-48 w-48 ml-auto text-white/20" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 2L2 7L12 12L22 7L12 2Z" stroke="currentColor" stroke-width="1"
                                stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M2 17L12 22L22 17" stroke="currentColor" stroke-width="1" stroke-linecap="round"
                                stroke-linejoin="round" />
                            <path d="M2 12L12 17L22 12" stroke="currentColor" stroke-width="1" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        {{-- Admin Dashboard --}}
        @if($role === 'admin')
            {{-- Stats Grid --}}
            <div>
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                    <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                    Overview
                </h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Stat Card -->
                    <div
                        class="bg-white/60 dark:bg-gray-800/60 backdrop-blur-md rounded-2xl p-6 shadow-sm border border-white/20 dark:border-gray-700/50 hover:shadow-lg hover:border-indigo-100 dark:hover:border-indigo-900/50 transition-all duration-300 group">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Modules</p>
                                <h3
                                    class="text-3xl font-bold text-gray-900 dark:text-white mt-2 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
                                    {{ $stats['total_modules'] ?? 0 }}</h3>
                            </div>
                            <div
                                class="p-3 bg-indigo-50 dark:bg-indigo-900/30 rounded-xl text-indigo-600 dark:text-indigo-400 group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div
                        class="bg-white/60 dark:bg-gray-800/60 backdrop-blur-md rounded-2xl p-6 shadow-sm border border-white/20 dark:border-gray-700/50 hover:shadow-lg hover:border-green-100 dark:hover:border-green-900/50 transition-all duration-300 group">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Users</p>
                                <h3
                                    class="text-3xl font-bold text-gray-900 dark:text-white mt-2 group-hover:text-green-600 dark:group-hover:text-green-400 transition-colors">
                                    {{ $stats['total_users'] ?? 0 }}</h3>
                            </div>
                            <div
                                class="p-3 bg-green-50 dark:bg-green-900/30 rounded-xl text-green-600 dark:text-green-400 group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div
                        class="bg-white/60 dark:bg-gray-800/60 backdrop-blur-md rounded-2xl p-6 shadow-sm border border-white/20 dark:border-gray-700/50 hover:shadow-lg hover:border-pink-100 dark:hover:border-pink-900/50 transition-all duration-300 group">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Enrollments</p>
                                <h3
                                    class="text-3xl font-bold text-gray-900 dark:text-white mt-2 group-hover:text-pink-600 dark:group-hover:text-pink-400 transition-colors">
                                    {{ $stats['total_enrolments'] ?? 0 }}</h3>
                            </div>
                            <div
                                class="p-3 bg-pink-50 dark:bg-pink-900/30 rounded-xl text-pink-600 dark:text-pink-400 group-hover:scale-110 transition-transform">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Quick Actions & Recent --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                {{-- Quick Actions --}}
                <div class="lg:col-span-2">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                        Quick Actions
                    </h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <a href="{{ route('modules.create') }}"
                            class="group relative overflow-hidden bg-white/60 dark:bg-gray-800/60 backdrop-blur-md p-6 rounded-2xl shadow-sm border border-white/20 dark:border-gray-700/50 hover:shadow-md transition-all">
                            <div
                                class="absolute inset-0 bg-gradient-to-r from-indigo-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity">
                            </div>
                            <div class="flex items-center gap-4 relative z-10">
                                <div
                                    class="p-3 rounded-xl bg-indigo-100 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900 dark:text-white">Create Module</h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">Add a new course to the system</p>
                                </div>
                            </div>
                        </a>

                        <a href="{{ route('admin.users.index') }}"
                            class="group relative overflow-hidden bg-white/60 dark:bg-gray-800/60 backdrop-blur-md p-6 rounded-2xl shadow-sm border border-white/20 dark:border-gray-700/50 hover:shadow-md transition-all">
                            <div
                                class="absolute inset-0 bg-gradient-to-r from-purple-500/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity">
                            </div>
                            <div class="flex items-center gap-4 relative z-10">
                                <div
                                    class="p-3 rounded-xl bg-purple-100 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold text-gray-900 dark:text-white">Manage Users</h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">View, edit, or remove users</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>

                {{-- Recent Activity --}}
                <div class="bg-white/60 dark:bg-gray-800/60 backdrop-blur-md rounded-2xl p-6 shadow-sm border border-white/20 dark:border-gray-700/50">
                    <h3 class="font-bold text-gray-900 dark:text-white mb-4">Recent Modules</h3>
                    @if(isset($recent_modules) && $recent_modules->count() > 0)
                        <div class="space-y-4">
                            @foreach($recent_modules as $module)
                                <a href="{{ route('modules.show', $module) }}"
                                    class="flex items-center gap-3 p-3 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                    <div
                                        class="w-10 h-10 rounded-lg bg-gray-100 dark:bg-gray-700 flex items-center justify-center text-gray-500 dark:text-gray-400 font-bold text-xs">
                                        {{ substr($module->code, 0, 3) }}
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900 dark:text-white text-sm line-clamp-1">{{ $module->name }}
                                        </p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $module->code }}</p>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8 text-gray-400 dark:text-gray-500 text-sm">
                            No modules created yet.
                        </div>
                    @endif
                </div>
            </div>
        @endif

        {{-- Teacher Dashboard --}}
        @if($role === 'teacher')
            {{-- Teacher Quick View & Stats --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white/60 dark:bg-gray-800/60 backdrop-blur-md rounded-2xl p-6 shadow-sm border border-white/20 dark:border-gray-700/50">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Students</p>
                    <h3 class="text-3xl font-bold text-gray-900 dark:text-white mt-2">{{ $total_students ?? 0 }}</h3>
                </div>

                <a href="{{ route('teacher.modules.index') }}"
                    class="group bg-white/60 dark:bg-gray-800/60 backdrop-blur-md rounded-2xl p-6 shadow-sm border border-white/20 dark:border-gray-700/50 hover:shadow-md transition-all flex items-center justify-between">
                    <div>
                        <h3
                            class="font-bold text-gray-900 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
                            My Modules</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">View your assigned courses</p>
                    </div>
                    <div
                        class="p-3 bg-indigo-50 dark:bg-indigo-900/30 rounded-xl text-indigo-600 dark:text-indigo-400 group-hover:bg-indigo-100 dark:group-hover:bg-indigo-900/50 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                </a>

                <a href="{{ route('profile.edit') }}"
                    class="group bg-white/60 dark:bg-gray-800/60 backdrop-blur-md rounded-2xl p-6 shadow-sm border border-white/20 dark:border-gray-700/50 hover:shadow-md transition-all flex items-center justify-between">
                    <div>
                        <h3
                            class="font-bold text-gray-900 dark:text-white group-hover:text-purple-600 dark:group-hover:text-purple-400 transition-colors">
                            My Profile</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Update your information</p>
                    </div>
                    <div
                        class="p-3 bg-purple-50 dark:bg-purple-900/30 rounded-xl text-purple-600 dark:text-purple-400 group-hover:bg-purple-100 dark:group-hover:bg-purple-900/50 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                </a>
            </div>

            @if(isset($my_modules) && $my_modules->count() > 0)
                <div class="mt-8">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">My Assigned Modules</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($my_modules as $module)
                            <a href="{{ route('teacher.modules.show', $module) }}"
                                class="bg-white/60 dark:bg-gray-800/60 backdrop-blur-md rounded-2xl p-6 shadow-sm border border-white/20 dark:border-gray-700/50 hover:ring-2 hover:ring-indigo-500/20 transition-all group">
                                <div class="flex items-center justify-between mb-4">
                                    <span
                                        class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300">{{ $module->code }}</span>
                                    <svg class="w-5 h-5 text-gray-400 group-hover:text-indigo-500 transition-colors" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                    </svg>
                                </div>
                                <h4
                                    class="text-lg font-bold text-gray-900 dark:text-white mb-2 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
                                    {{ $module->name }}</h4>
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $module->active_students_count }} active students
                                </p>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        @endif

        {{-- Student Dashboard --}}
        @if(in_array($role, ['user', 'old_student']))
            <div class="space-y-8">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <a href="{{ route('modules.index') }}"
                        class="group bg-white/60 dark:bg-gray-800/60 backdrop-blur-md rounded-2xl p-6 shadow-sm border border-white/20 dark:border-gray-700/50 hover:shadow-md transition-all flex items-center justify-between">
                        <div>
                            <h3
                                class="font-bold text-gray-900 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
                                Browse Modules</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Discover new courses</p>
                        </div>
                        <div
                            class="p-3 bg-blue-50 dark:bg-blue-900/30 rounded-xl text-blue-600 dark:text-blue-400 group-hover:bg-blue-100 dark:group-hover:bg-blue-900/50 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                    </a>
                </div>

                @if(isset($current_enrolments) && $current_enrolments->count() > 0)
                    <div>
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                            <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                            Current Enrollments
                        </h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @foreach($current_enrolments as $enrolment)
                                <a href="{{ route('modules.show', $enrolment->module) }}"
                                    class="block p-6 bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700/50 hover:border-indigo-100 dark:hover:border-indigo-500/30 hover:shadow-md transition-all group">
                                    <div class="flex justify-between items-start mb-4">
                                        <span
                                            class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300">In
                                            Progress</span>
                                        <span class="text-xs text-gray-500 dark:text-gray-400">Started
                                            {{ $enrolment->started_at?->format('M d') }}</span>
                                    </div>
                                    <h3
                                        class="text-lg font-bold text-gray-900 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
                                        {{ $enrolment->module->name }}</h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ $enrolment->module->code }}</p>

                                    <div
                                        class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-700/50 flex items-center justify-between">
                                        <span
                                            class="text-sm font-medium text-indigo-600 dark:text-indigo-400 group-hover:underline">Continue
                                            Learning</span>
                                        <svg class="w-4 h-4 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        @endif
    </div>
@endsection