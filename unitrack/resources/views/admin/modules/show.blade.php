@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto space-y-8">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.modules.index') }}"
                class="p-2 rounded-xl bg-white/50 dark:bg-gray-800/50 border border-gray-100 dark:border-gray-700 text-gray-500 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-all">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Admin Enrolment Manager</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $module->code }} — {{ $module->name }}</p>
            </div>
        </div>

        <!-- Teacher Section -->
        <div
            class="bg-indigo-600/5 dark:bg-indigo-900/5 backdrop-blur-md rounded-2xl p-6 border border-indigo-100 dark:border-indigo-900/30 flex items-center justify-between">
            <div>
                <h3 class="text-xs font-bold text-indigo-900/50 dark:text-indigo-100/50 uppercase tracking-widest mb-1">
                    Assigned Teacher</h3>
                <p class="text-lg font-bold text-indigo-900 dark:text-indigo-100">
                    {{ $module->teacher?->name ?? '— Unassigned' }}</p>
            </div>
            <div class="p-3 bg-indigo-600 text-white rounded-xl shadow-lg shadow-indigo-500/20">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
            </div>
        </div>

        <!-- Students List -->
        <div
            class="bg-white/60 dark:bg-gray-800/60 backdrop-blur-md rounded-2xl p-6 shadow-sm border border-white/20 dark:border-gray-700/50">
            <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                    </path>
                </svg>
                Enrolled Students
            </h2>

            @if($module->enrolments->isEmpty())
                <div class="text-center py-12">
                    <p class="text-gray-500 dark:text-gray-400 italic">No students currently enrolled in this module.</p>
                </div>
            @else
                <div class="grid gap-4">
                    @foreach($module->enrolments as $enrol)
                        <div
                            class="group p-4 bg-white/40 dark:bg-gray-900/40 rounded-xl border border-gray-100 dark:border-gray-700 hover:border-red-500/30 transition-all flex justify-between items-center">
                            <div>
                                <div class="font-bold text-gray-900 dark:text-white">{{ $enrol->user->name }}</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400 font-medium">Joined
                                    {{ $enrol->started_at?->format('F d, Y') ?? 'Unknown Date' }}</div>
                            </div>
                            <form method="POST" action="{{ route('admin.modules.students.destroy', [$module, $enrol]) }}"
                                onsubmit="return confirm('Remove this student from module?')">
                                @csrf
                                @method('DELETE')
                                <button
                                    class="px-4 py-2 bg-red-100 dark:bg-red-900/30 text-red-600 dark:text-red-400 text-xs font-bold rounded-lg hover:bg-red-600 hover:text-white transition-all">
                                    Remove
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection