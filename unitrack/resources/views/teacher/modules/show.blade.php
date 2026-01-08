@extends('layouts.app')

@section('content')
    <div class="space-y-8">
        <div class="flex items-center gap-4">
            <a href="{{ route('teacher.modules.index') }}"
                class="p-2 rounded-xl bg-white/50 dark:bg-gray-800/50 border border-gray-100 dark:border-gray-700 text-gray-500 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-all">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Students Management</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $module->code }} — {{ $module->name }}</p>
            </div>
        </div>

        @if(session('status'))
            <div
                class="p-4 rounded-xl bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 text-green-800 dark:text-green-300 text-sm">
                {{ session('status') }}
            </div>
        @endif

        <div
            class="bg-white/60 dark:bg-gray-800/60 backdrop-blur-md rounded-2xl shadow-sm border border-white/20 dark:border-gray-700/50 overflow-hidden">
            @if($students->isEmpty())
                <div class="text-center py-20">
                    <div
                        class="w-16 h-16 bg-gray-100 dark:bg-gray-700/50 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">No students enrolled</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">When students enrol in this module, they will
                        appear here.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50/50 dark:bg-gray-900/50">
                                <th
                                    class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest">
                                    Student</th>
                                <th
                                    class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest">
                                    Status</th>
                                <th
                                    class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest">
                                    Started</th>
                                <th
                                    class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest">
                                    Completed</th>
                                <th
                                    class="px-6 py-4 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest text-right">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @foreach($students as $enrol)
                                <tr class="hover:bg-white/40 dark:hover:bg-gray-800/40 transition-colors"
                                    data-enrol-id="{{ $enrol->id }}">
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-gray-900 dark:text-white">{{ $enrol->user->name }}</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">{{ $enrol->user->email }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="enrol-status px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase {{ $enrol->status === 'pass' ? 'bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-400' : ($enrol->status === 'fail' ? 'bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-400' : 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/40 dark:text-yellow-400') }}">
                                            {{ $enrol->status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400 enrol-started">
                                        {{ $enrol->started_at?->format('M d, Y') ?? '—' }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400 enrol-completed">
                                        {{ $enrol->completed_at?->format('M d, Y') ?? '—' }}
                                    </td>
                                    <td class="px-6 py-4 text-right enrol-actions">
                                        @can('grade', $enrol)
                                            <div class="flex justify-end gap-2">
                                                <form method="POST"
                                                    action="{{ route('teacher.modules.enrolments.grade', [$module, $enrol]) }}"
                                                    class="grade-form">
                                                    @csrf
                                                    <input type="hidden" name="status" value="pass">
                                                    <button
                                                        class="px-4 py-1.5 text-xs font-bold bg-green-600 hover:bg-green-500 text-white rounded-lg shadow-md shadow-green-500/10 transition-all active:scale-95">Pass</button>
                                                </form>
                                                <form method="POST"
                                                    action="{{ route('teacher.modules.enrolments.grade', [$module, $enrol]) }}"
                                                    class="grade-form">
                                                    @csrf
                                                    <input type="hidden" name="status" value="fail">
                                                    <button
                                                        class="px-4 py-1.5 text-xs font-bold bg-red-600 hover:bg-red-500 text-white rounded-lg shadow-md shadow-red-500/10 transition-all active:scale-95">Fail</button>
                                                </form>
                                            </div>
                                        @else
                                            <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">—</span>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                const toast = (message, success = true) => {
                    const el = document.createElement('div');
                    el.className = `fixed top-12 left-1/2 -translate-x-1/2 px-6 py-3 rounded-2xl shadow-xl backdrop-blur-md z-[100] transition-all duration-300 transform translate-y-4 opacity-0 font-bold text-sm ${success ? 'bg-indigo-600/90 text-white border border-white/20' : 'bg-red-600/90 text-white border border-white/20'}`;
                    el.textContent = message;
                    document.body.appendChild(el);

                    // Animate in
                    requestAnimationFrame(() => {
                        el.classList.remove('translate-y-4', 'opacity-0');
                        el.classList.add('translate-y-0', 'opacity-100');
                    });

                    setTimeout(() => {
                        el.classList.add('opacity-0', '-translate-y-4');
                        setTimeout(() => el.remove(), 300);
                    }, 3000);
                };

                document.querySelectorAll('.grade-form').forEach(form => {
                    form.addEventListener('submit', async function (e) {
                        e.preventDefault();
                        const action = this.getAttribute('action');
                        const status = this.querySelector('input[name="status"]').value;
                        const row = this.closest('tr');
                        try {
                            const res = await fetch(action, {
                                method: 'POST',
                                headers: {
                                    'Accept': 'application/json',
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': token,
                                },
                                body: JSON.stringify({ status })
                            });

                            if (!res.ok) {
                                const err = await res.json().catch(() => null);
                                toast(err?.message || 'Failed to grade', false);
                                return;
                            }

                            const data = await res.json();

                            // Update Status Tag
                            const statusTag = row.querySelector('.enrol-status');
                            statusTag.textContent = data.status.toUpperCase();
                            statusTag.className = `enrol-status px-2.5 py-1 rounded-lg text-[10px] font-bold uppercase ${data.status === 'pass' ? 'bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-400' : 'bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-400'}`;

                            row.querySelector('.enrol-completed').textContent = new Date().toLocaleDateString('en-US', { month: 'short', day: '2-digit', year: 'numeric' });

                            // Remove Actions
                            row.querySelector('.enrol-actions').innerHTML = '<span class="text-xs font-bold text-gray-400 uppercase tracking-widest">—</span>';

                            toast(`Student mark as ${data.status.toUpperCase()}`);
                        } catch (e) {
                            console.error(e);
                            toast('Network connection error', false);
                        }
                    });
                });
            });
        </script>
    </div>
@endsection