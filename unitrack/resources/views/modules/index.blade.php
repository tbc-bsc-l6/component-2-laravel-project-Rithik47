@extends('layouts.app')

@section('content')
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Modules</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">Discover and manage academic course modules</p>
        </div>

        <div class="flex items-center gap-4">
            <form method="GET" action="{{ route('modules.index') }}" class="flex gap-2">
                <input name="q" value="{{ request('q') }}"
                    class="bg-white/50 dark:bg-gray-800/50 border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-indigo-500 outlines-none transition-all dark:text-white"
                    placeholder="Search modules...">
                <button
                    class="bg-indigo-600 hover:bg-indigo-500 text-white px-4 py-2 rounded-xl text-sm font-medium transition-all shadow-lg shadow-indigo-500/20">Search</button>
            </form>

            @can('create', App\Models\Module::class)
                <a href="{{ route('modules.create') }}"
                    class="bg-white dark:bg-gray-800 text-gray-900 dark:text-white border border-gray-200 dark:border-gray-700 px-4 py-2 rounded-xl text-sm font-medium hover:bg-gray-50 dark:hover:bg-white/5 transition-all">
                    Create Module
                </a>
            @endcan
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @forelse($modules as $module)
            @include('modules._card', ['module' => $module])
        @empty
            <div class="col-span-full">
                <div
                    class="bg-white/50 dark:bg-gray-800/50 backdrop-blur-sm border border-gray-100 dark:border-gray-700 p-12 rounded-2xl text-center text-gray-500 dark:text-gray-400 shadow-sm">
                    <svg class="w-12 h-12 mx-auto text-gray-300 dark:text-gray-600 mb-4" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <p class="text-lg font-medium">No modules found</p>
                    <p class="text-sm">Try adjusting your search criteria.</p>
                </div>
            </div>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $modules->links() }}
    </div>
@endsection