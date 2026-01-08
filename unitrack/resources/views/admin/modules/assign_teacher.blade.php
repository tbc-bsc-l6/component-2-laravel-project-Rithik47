@extends('layouts.app')

@section('content')
    <div class="max-w-xl mx-auto space-y-8">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.modules.index') }}"
                class="p-2 rounded-xl bg-white/50 dark:bg-gray-800/50 border border-gray-100 dark:border-gray-700 text-gray-500 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-all">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Assign Teacher</h1>
        </div>

        <div
            class="bg-white/60 dark:bg-gray-800/60 backdrop-blur-md rounded-2xl p-8 shadow-sm border border-white/20 dark:border-gray-700/50">
            <div class="mb-8">
                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">Target Module</h3>
                <p class="text-xl font-bold text-gray-900 dark:text-white">{{ $module->code }} — {{ $module->name }}</p>
            </div>

            <form method="POST" action="{{ route('admin.modules.teacher.update', $module) }}" class="space-y-6">
                @csrf
                @method('PATCH')

                <div class="space-y-2">
                    <label
                        class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest ml-1">Select
                        Professor</label>
                    <select name="teacher_id"
                        class="w-full bg-white/50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-indigo-500 transition-all dark:text-white appearance-none">
                        <option value="" class="dark:bg-gray-900">-- Unassigned --</option>
                        @foreach($teachers as $t)
                            <option value="{{ $t->id }}" @if($module->teacher_id === $t->id) selected @endif
                                class="dark:bg-gray-900">
                                {{ $t->name }} ({{ $t->email }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-center gap-3 pt-4">
                    <button
                        class="flex-1 bg-indigo-600 hover:bg-indigo-500 text-white font-bold py-3 rounded-xl transition-all shadow-lg shadow-indigo-500/20 active:scale-[0.98]">
                        Confirm Assignment
                    </button>
                    <a href="{{ route('admin.modules.index') }}"
                        class="px-6 py-3 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 border border-gray-200 dark:border-gray-700 font-bold rounded-xl hover:bg-gray-50 dark:hover:bg-white/5 transition-all">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection