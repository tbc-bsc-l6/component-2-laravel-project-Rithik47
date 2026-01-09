<div
    class="bg-white/60 dark:bg-gray-800/60 backdrop-blur-md rounded-2xl shadow-sm border border-white/20 dark:border-gray-700/50 p-5 hover:shadow-xl hover:shadow-indigo-500/10 transition-all duration-300 transform hover:-translate-y-1 group flex flex-col justify-between">
    <div>
        <div class="flex items-start justify-between mb-4">
            <div class="flex items-center gap-3">
                <!-- Module icon -->
                <div
                    class="w-10 h-10 bg-indigo-50 dark:bg-indigo-900/40 text-indigo-600 dark:text-indigo-400 rounded-xl flex items-center justify-center transition-transform group-hover:rotate-12 duration-300 shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20" />
                        <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z" />
                    </svg>
                </div>

                <div>
                    <div class="text-[10px] font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-widest">
                        {{ $module->code }}</div>
                    <div class="text-lg font-bold text-gray-900 dark:text-white leading-tight mt-0.5">
                        {{ $module->name }}</div>
                </div>
            </div>

            <div
                class="text-[10px] font-bold px-2 py-0.5 rounded-full uppercase tracking-tighter {{ $module->is_archived ? 'bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-400' : 'bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-400' }}">
                {{ $module->is_archived ? 'Archived' : 'Active' }}
            </div>
        </div>

        <div class="text-xs text-gray-500 dark:text-gray-400 flex items-center gap-1.5 mt-2">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            Created {{ $module->created_at?->diffForHumans() }}
        </div>
    </div>

    <div class="mt-6 flex items-center gap-2">
        <a href="{{ route('modules.show', $module) }}"
            class="flex-1 text-center text-xs font-bold py-2 rounded-xl bg-indigo-600 text-white hover:bg-indigo-500 transition-colors shadow-lg shadow-indigo-500/20">
            View Details
        </a>
        @can('update', $module)
            <a href="{{ route('modules.edit', $module) }}"
                class="p-2 rounded-xl border border-gray-200 dark:border-gray-700 text-gray-500 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-white/5 transition-colors"
                title="Edit">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                    </path>
                </svg>
            </a>
        @endcan

        @can('delete', $module)
            <form method="POST" action="{{ route('modules.destroy', $module) }}"
                onsubmit="return confirm('Delete this module?')" class="flex shadow-none">
                @csrf
                @method('DELETE')
                <button
                    class="p-2 rounded-xl border border-red-200 dark:border-red-900/50 text-red-500 hover:bg-red-50 dark:hover:bg-red-900/10 transition-colors"
                    title="Delete">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                        </path>
                    </svg>
                </button>
            </form>
        @endcan
    </div>
</div>