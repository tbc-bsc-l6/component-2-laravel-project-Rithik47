@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto space-y-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Module Management</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400">Total Modules: <span
                        class="font-bold text-indigo-600 dark:text-indigo-400">{{ $modules->total() }}</span></p>
            </div>
        </div>

        <div
            class="bg-white/60 dark:bg-gray-800/60 backdrop-blur-md rounded-2xl shadow-sm border border-white/20 dark:border-gray-700/50 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left border-collapse">
                    <thead
                        class="bg-gray-50/50 dark:bg-gray-900/30 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest border-b border-gray-100 dark:border-gray-700">
                        <tr>
                            <th class="px-6 py-4">Module Details</th>
                            <th class="px-6 py-4">Assigned Teacher</th>
                            <th class="px-6 py-4 text-center">Stats</th>
                            <th class="px-6 py-4 text-center">Status</th>
                            <th class="px-6 py-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        @foreach($modules as $mod)
                            <tr class="hover:bg-gray-50/50 dark:hover:bg-white/5 transition-colors group">
                                <td class="px-6 py-4">
                                    <div class="font-bold text-gray-900 dark:text-white">{{ $mod->name }}</div>
                                    <div class="text-xs text-indigo-600 dark:text-indigo-400 font-medium">{{ $mod->code }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <select data-module-id="{{ $mod->id }}" name="teacher_id"
                                        class="teacher-select bg-white/50 dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 text-xs rounded-lg px-3 py-1.5 focus:ring-1 focus:ring-indigo-500 transition-all dark:text-white w-full max-w-[200px]">
                                        <option value="">-- Unassigned --</option>
                                        @foreach($teachers as $t)
                                            <option value="{{ $t->id }}" @if($mod->teacher_id === $t->id) selected @endif>
                                                {{ $t->name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="inline-flex items-center gap-1.5 text-xs text-gray-600 dark:text-gray-400">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                                            </path>
                                        </svg>
                                        {{ $mod->active_students_count }} students
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span
                                        class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-tighter {{ $mod->is_archived ? 'bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-400' : 'bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-400' }}">
                                        {{ $mod->is_archived ? 'Archived' : 'Active' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('modules.show', $mod) }}"
                                            class="p-2 rounded-lg bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 hover:bg-indigo-100 dark:hover:bg-indigo-900/50 transition-all"
                                            title="View Module">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                </path>
                                            </svg>
                                        </a>
                                        <a href="{{ route('admin.modules.show', $mod) }}"
                                            class="p-2 rounded-lg bg-purple-50 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400 hover:bg-purple-100 dark:hover:bg-purple-900/50 transition-all"
                                            title="Manage Students">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                                                </path>
                                            </svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-8">{{ $modules->links() }}</div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            const toast = (message, success = true) => {
                const el = document.createElement('div');
                el.className = `fixed top-6 right-6 px-4 py-2 rounded shadow ${success ? 'bg-green-600 text-white' : 'bg-red-600 text-white'}`;
                el.textContent = message;
                document.body.appendChild(el);
                setTimeout(() => el.remove(), 3000);
            };

            document.querySelectorAll('.teacher-select').forEach(select => {
                select.addEventListener('change', async function () {
                    const moduleId = this.dataset.moduleId;
                    const teacherId = this.value || null;
                    try {
                        const res = await fetch(`/admin/modules/${moduleId}/teacher`, {
                            method: 'PATCH',
                            headers: {
                                'Accept': 'application/json',
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': token,
                            },
                            body: JSON.stringify({ teacher_id: teacherId })
                        });

                        if (!res.ok) {
                            const err = await res.json().catch(() => null);
                            toast(err?.message || 'Failed to assign teacher', false);
                            return;
                        }

                        const data = await res.json();
                        toast('Teacher assignment updated');
                    } catch (e) {
                        console.error(e);
                        toast('Network error', false);
                    }
                });
            });
        });
    </script>
@endsection