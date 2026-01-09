@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto space-y-8">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white">Student Dashboard</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">Track your learning progress and discover new modules</p>
        </div>

        <!-- Current Enrolments -->
        @if(isset($current))
            <div
                class="bg-white/60 dark:bg-gray-800/60 backdrop-blur-md rounded-2xl p-6 shadow-sm border border-white/20 dark:border-gray-700/50">
                <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                    <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                        </path>
                    </svg>
                    Current Active Modules
                </h2>
                @if($current->isEmpty())
                    <div class="text-center py-8">
                        <p class="text-gray-500 dark:text-gray-400 italic">You are not enrolled in any active modules.</p>
                        <a href="{{ route('modules.index') }}"
                            class="inline-block mt-4 text-sm font-bold text-indigo-600 dark:text-indigo-400 hover:underline">Browse
                            available modules &rarr;</a>
                    </div>
                @else
                    <div class="grid gap-4">
                        @foreach($current as $enrol)
                            <div
                                class="group p-4 bg-white/40 dark:bg-gray-900/40 rounded-xl border border-gray-100 dark:border-gray-700 hover:border-indigo-500/50 transition-all">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 rounded-lg bg-indigo-50 dark:bg-indigo-900/30 flex items-center justify-center text-indigo-600 dark:text-indigo-400 font-bold text-xs">
                                            {{ substr($enrol->module->code, 0, 3) }}
                                        </div>
                                        <div>
                                            <div class="font-bold text-gray-900 dark:text-white">{{ $enrol->module->code }} —
                                                {{ $enrol->module->name }}</div>
                                            <div class="text-[10px] text-gray-500 dark:text-gray-400 uppercase tracking-wider">Started
                                                {{ $enrol->started_at?->diffForHumans() ?? 'Unknown' }}</div>
                                        </div>
                                    </div>
                                    <a href="{{ route('modules.show', $enrol->module) }}"
                                        class="p-2 rounded-lg hover:bg-white dark:hover:bg-gray-800 text-gray-400 hover:text-indigo-600 transition-all">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                            </path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        @endif

        <!-- Available Modules -->
        @if(isset($available))
            <div
                class="bg-indigo-600/5 dark:bg-indigo-900/5 backdrop-blur-md rounded-2xl p-6 border border-indigo-100 dark:border-indigo-900/30">
                <h2 class="text-lg font-bold text-indigo-900 dark:text-indigo-100 mb-6 flex items-center gap-2">
                    <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                        </path>
                    </svg>
                    Available for Enrolment
                </h2>
                @if($available->isEmpty())
                    <p class="text-sm text-indigo-600/60 dark:text-indigo-400/60 italic text-center py-6">No new modules available
                        to enrol at this time.</p>
                @else
                    <div class="grid gap-3">
                        @foreach($available as $m)
                            <div
                                class="p-4 bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-indigo-50 dark:border-indigo-900/20 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                                <div>
                                    <div class="font-bold text-gray-900 dark:text-white">{{ $m->code }} — {{ $m->name }}</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">Capacity: <span
                                            class="text-indigo-600 dark:text-indigo-400 font-bold">{{ $m->activeStudentsCount() }}</span>
                                        / 10</div>
                                </div>
                                <form method="POST" action="{{ route('modules.enrol', $m) }}" class="w-full sm:w-auto">
                                    @csrf
                                    <button
                                        class="w-full sm:w-auto px-6 py-2 rounded-xl bg-indigo-600 text-white text-xs font-bold shadow-lg shadow-indigo-500/20 hover:bg-indigo-500 transition-all active:scale-[0.98]">
                                        Enrol
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        @endif

        <!-- History -->
        @if(isset($history))
            <div class="bg-gray-50/50 dark:bg-gray-900/50 rounded-2xl p-6 border border-gray-200 dark:border-gray-800">
                <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Completed & Past Modules
                </h2>
                @if($history->isEmpty())
                    <p class="text-xs text-gray-500 dark:text-gray-400 italic text-center py-4">You haven't completed any modules
                        yet.</p>
                @else
                    <div class="grid gap-3">
                        @foreach($history as $enrol)
                            <div
                                class="px-5 py-4 bg-white/40 dark:bg-gray-800/40 rounded-xl border border-gray-100 dark:border-gray-700 flex justify-between items-center opacity-75">
                                <div>
                                    <div class="font-bold text-gray-700 dark:text-gray-300">{{ $enrol->module->code }} —
                                        {{ $enrol->module->name }}</div>
                                    <div
                                        class="text-[10px] text-gray-500 dark:text-gray-500 font-bold uppercase tracking-widest mt-0.5">
                                        Completed: {{ $enrol->completed_at?->format('M d, Y') ?? 'N/A' }}</div>
                                </div>
                                <span
                                    class="px-2 py-0.5 rounded-lg bg-green-50 dark:bg-green-900/20 text-green-600 dark:text-green-400 text-[10px] font-bold uppercase">{{ $enrol->status }}</span>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        @endif
    </div>
@endsection