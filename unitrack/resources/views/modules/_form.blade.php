@csrf

<div
    class="p-4 rounded-xl bg-amber-50 dark:bg-amber-900/10 border border-amber-200 dark:border-amber-900/30 flex items-start gap-3 mb-6">
    <svg class="w-5 h-5 text-amber-600 dark:text-amber-400 mt-0.5" fill="none" stroke="currentColor"
        viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z">
        </path>
    </svg>
    <div class="text-sm text-amber-800 dark:text-amber-300">
        <span class="font-bold">Capacity Limitation:</span> Each module is restricted to a maximum of <span
            class="font-extrabold underline decoration-amber-500/30">10 students</span> only. This limit is strictly
        enforced.
    </div>
</div>

<div class="space-y-1">
    <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest ml-1">Module
        Code</label>
    <input name="code" value="{{ old('code', $module->code ?? '') }}"
        class="w-full bg-white/50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-indigo-500 transition-all dark:text-white"
        placeholder="e.g. CS101" required>
</div>

<div class="space-y-1">
    <label class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest ml-1">Module
        Name</label>
    <input name="name" value="{{ old('name', $module->name ?? '') }}"
        class="w-full bg-white/50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-indigo-500 transition-all dark:text-white"
        placeholder="e.g. Introduction to Programming" required>
</div>

<div
    class="flex items-center gap-3 p-3 bg-gray-50/50 dark:bg-gray-900/50 rounded-xl border border-gray-100 dark:border-gray-700">
    <div class="relative flex items-center">
        <input type="checkbox" name="is_archived" id="is_archived" value="1" {{ old('is_archived', $module->is_archived ?? false) ? 'checked' : '' }} class="w-5 h-5 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
    </div>
    <label for="is_archived" class="text-sm font-medium text-gray-700 dark:text-gray-300 cursor-pointer">Archive this
        module</label>
</div>