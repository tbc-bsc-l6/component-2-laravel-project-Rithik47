@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto space-y-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Your Teaching Modules</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">Manage and track students in your assigned courses</p>
        </div>

        <div
            class="bg-white/60 dark:bg-gray-800/60 backdrop-blur-md rounded-2xl p-6 shadow-sm border border-white/20 dark:border-gray-700/50">
            @if($modules->isEmpty())
                <div class="text-center py-12">
                    <svg class="w-12 h-12 mx-auto text-gray-300 dark:text-gray-600 mb-4" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                        </path>
                    </svg>
                    <p class="text-gray-500 dark:text-gray-400">You have no modules assigned at the moment.</p>
                </div>
            @else
                <div class="grid gap-4">
                    @foreach($modules as $m)
                        <div
                            class="group p-5 border border-gray-100 dark:border-gray-700 rounded-2xl flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 hover:bg-white/80 dark:hover:bg-gray-700/50 transition-all duration-300 shadow-sm hover:shadow-md">
                            <div class="flex items-center gap-4">
                                <div
                                    class="w-12 h-12 rounded-xl bg-indigo-50 dark:bg-indigo-900/30 flex items-center justify-center text-indigo-600 dark:text-indigo-400 font-bold group-hover:scale-110 transition-transform">
                                    {{ substr($m->code, 0, 3) }}
                                </div>
                                <div>
                                    <div
                                        class="font-bold text-gray-900 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
                                        {{ $m->code }} — {{ $m->name }}</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400 mt-1 flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                                            </path>
                                        </svg>
                                        {{ $m->active_students_count }} active students
                                    </div>
                                </div>
                            </div>
                            <a href="{{ route('teacher.modules.show', $m) }}"
                                class="w-full sm:w-auto text-center px-4 py-2 rounded-xl bg-indigo-600 text-white text-sm font-bold shadow-lg shadow-indigo-500/20 hover:bg-indigo-500 transition-all">
                                Manage Class
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection