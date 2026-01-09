@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto space-y-8">
        <div class="flex items-center gap-4">
            <a href="{{ route('modules.index') }}"
                class="p-2 rounded-xl bg-white/50 dark:bg-gray-800/50 border border-gray-100 dark:border-gray-700 text-gray-500 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-all">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Module Details</h1>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Info -->
            <div class="lg:col-span-2 space-y-6">
                <div
                    class="bg-white/60 dark:bg-gray-800/60 backdrop-blur-md rounded-2xl p-8 shadow-sm border border-white/20 dark:border-gray-700/50">
                    <div class="flex items-center gap-4 mb-8">
                        <div
                            class="w-16 h-16 bg-indigo-50 dark:bg-indigo-900/40 text-indigo-600 dark:text-indigo-400 rounded-2xl flex items-center justify-center shadow-sm">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <div class="text-sm font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-widest">
                                {{ $module->code }}</div>
                            <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white">{{ $module->name }}</h2>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-8 py-6 border-y border-gray-100 dark:border-gray-700">
                        <div>
                            <p class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-1">
                                Status</p>
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold {{ $module->is_archived ? 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400' : 'bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-400' }}">
                                {{ $module->is_archived ? 'Archived' : 'Active' }}
                            </span>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-1">
                                Students</p>
                            <p class="text-lg font-bold text-gray-900 dark:text-white">{{ $module->active_students_count }}
                                Enrolled</p>
                        </div>
                    </div>

                    <div class="mt-8">
                        <p class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed">
                            This module provides comprehensive coverage of {{ $module->name }}. Students will engage in
                            rigorous academic study and practical sessions to master the core concepts.
                        </p>
                    </div>
                </div>

                @can('update', $module)
                    <div class="flex gap-4">
                        <a href="{{ route('modules.edit', $module) }}"
                            class="flex-1 text-center py-3 bg-white dark:bg-gray-800 text-gray-900 dark:text-white border border-gray-200 dark:border-gray-700 font-bold rounded-xl hover:bg-gray-50 dark:hover:bg-white/5 transition-all">
                            Edit Module
                        </a>
                        <form method="POST" action="{{ route('modules.destroy', $module) }}"
                            onsubmit="return confirm('Delete this module?')" class="flex shadow-none">
                            @csrf
                            @method('DELETE')
                            <button
                                class="px-6 py-3 border border-red-200 dark:border-red-900/50 text-red-500 font-bold rounded-xl hover:bg-red-50 dark:hover:bg-red-900/10 transition-all">
                                Delete
                            </button>
                        </form>
                    </div>
                @endcan
            </div>

            <!-- Sidebar / Enrolment -->
            <div class="space-y-6">
                <div class="bg-indigo-600 rounded-2xl p-6 text-white shadow-xl shadow-indigo-500/20">
                    <h3 class="text-lg font-bold mb-4">Registration</h3>
                    @auth
                        @if(auth()->user()->enrolments()->where('module_id', $module->id)->exists())
                            <div class="p-4 bg-white/10 rounded-xl border border-white/20 flex items-center gap-3">
                                <svg class="w-6 h-6 text-indigo-200" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-sm font-medium">Already Enrolled</span>
                            </div>
                        @else
                            @if($module->is_archived)
                                <p class="text-xs text-indigo-100 opacity-80 mb-4">This module is currently archived and not accepting
                                    new students.</p>
                                <button disabled
                                    class="w-full py-3 bg-white/20 rounded-xl font-bold text-white/50 cursor-not-allowed">Archived</button>
                            @elseif($module->activeStudentsCount() >= 10)
                                <p class="text-xs text-indigo-100 opacity-80 mb-4">This module has reached its maximum capacity of
                                    students.</p>
                                <button disabled
                                    class="w-full py-3 bg-white/20 rounded-xl font-bold text-white/50 cursor-not-allowed">Module
                                    Full</button>
                            @elseif(auth()->user()->activeEnrolmentsCount() >= 4)
                                <p class="text-xs text-indigo-100 opacity-80 mb-4">You have reached the limit of 4 active enrollments.
                                </p>
                                <button disabled
                                    class="w-full py-3 bg-white/20 rounded-xl font-bold text-white/50 cursor-not-allowed">Limit
                                    Reached</button>
                            @else
                                <p class="text-xs text-indigo-100 opacity-80 mb-4">Join this course today to start your learning
                                    journey.</p>
                                <form method="POST" action="{{ route('modules.enrol', $module) }}">
                                    @csrf
                                    <button
                                        class="w-full py-3 bg-white text-indigo-600 rounded-xl font-bold hover:bg-gray-50 transition-all transform active:scale-95 shadow-lg">
                                        Enrol Now
                                    </button>
                                </form>
                            @endif
                        @endif
                    @else
                        <p class="text-xs text-indigo-100 opacity-80 mb-4">Please sign in to enroll in this module.</p>
                        <a href="{{ route('login') }}"
                            class="block w-full text-center py-3 bg-white text-indigo-600 rounded-xl font-bold hover:bg-gray-50 transition-all">Sign
                            In</a>
                    @endauth
                </div>

                <div
                    class="bg-white/60 dark:bg-gray-800/60 backdrop-blur-md rounded-2xl p-6 border border-white/20 dark:border-gray-700/50">
                    <h4 class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-4">Academic
                        Team</h4>
                    @if($module->teacher)
                        <div class="flex items-center gap-3">
                            <div
                                class="w-10 h-10 rounded-full bg-gradient-to-br from-indigo-500 to-purple-500 flex items-center justify-center text-white font-bold text-sm">
                                {{ strtoupper(substr($module->teacher->name, 0, 1)) }}
                            </div>
                            <div>
                                <div class="text-sm font-bold text-gray-900 dark:text-white">{{ $module->teacher->name }}</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">Head Lecturer</div>
                            </div>
                        </div>
                    @else
                        <p class="text-xs text-gray-500 dark:text-gray-400 italic">No teacher assigned yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection