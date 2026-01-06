@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto space-y-8">
    <div class="flex items-center gap-4">
        <a href="{{ route('modules.index') }}" class="p-2 rounded-xl bg-white/50 dark:bg-gray-800/50 border border-gray-100 dark:border-gray-700 text-gray-500 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-all">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
        </a>
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Create New Module</h1>
    </div>

    <div class="bg-white/60 dark:bg-gray-800/60 backdrop-blur-md rounded-2xl p-8 shadow-sm border border-white/20 dark:border-gray-700/50">
        @if($errors->any())
            <div class="mb-6 p-4 rounded-xl bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-300 text-sm">
                <div class="font-bold mb-1">Please correct the following:</div>
                <ul class="list-disc pl-5 opacity-80">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('modules.store') }}" class="space-y-6">
            @csrf

            <div class="space-y-1">
                <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest ml-1">Module Code</label>
                <input name="code" value="{{ old('code') }}" 
                       class="w-full bg-white/50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-indigo-500 transition-all dark:text-white" 
                       placeholder="e.g. CS101" required>
            </div>

            <div class="space-y-1">
                <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest ml-1">Module Name</label>
                <input name="name" value="{{ old('name') }}" 
                       class="w-full bg-white/50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-indigo-500 transition-all dark:text-white" 
                       placeholder="e.g. Introduction to Programming" required>
            </div>

            <div class="flex items-center gap-3 p-3 bg-gray-50/50 dark:bg-gray-900/50 rounded-xl border border-gray-100 dark:border-gray-700">
                <div class="relative flex items-center">
                    <input type="checkbox" name="is_archived" id="is_archived" value="1" {{ old('is_archived') ? 'checked' : '' }}
                           class="w-5 h-5 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                </div>
                <label for="is_archived" class="text-sm font-medium text-gray-700 dark:text-gray-300 cursor-pointer">Archive this module immediately</label>
            </div>

            <div class="flex items-center gap-3 pt-4">
                <button class="flex-1 bg-indigo-600 hover:bg-indigo-500 text-white font-bold py-3 rounded-xl transition-all shadow-lg shadow-indigo-500/20 active:scale-[0.98]">
                    Create Module
                </button>
                <a href="{{ route('modules.index') }}" 
                   class="px-6 py-3 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 border border-gray-200 dark:border-gray-700 font-bold rounded-xl hover:bg-gray-50 dark:hover:bg-white/5 transition-all">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection