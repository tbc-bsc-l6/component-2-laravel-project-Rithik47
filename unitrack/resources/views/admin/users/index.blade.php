@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto space-y-8">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">User Management</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400">Manage institution roles and teacher accounts</p>
            </div>
        </div>

        @if(session('success'))
            <div x-data="{show: true}" x-show="show" x-init="setTimeout(()=> show = false, 4000)"
                class="rounded-xl bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 text-green-800 dark:text-green-300 px-4 py-3 shadow-sm flex items-center gap-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        <!-- Create Teacher Section -->
        <div
            class="bg-white/60 dark:bg-gray-800/60 backdrop-blur-md rounded-2xl p-6 shadow-sm border border-white/20 dark:border-gray-700/50">
            <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-6 flex items-center gap-2">
                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                </svg>
                Assign New Teacher
            </h2>
            <form method="POST" action="{{ route('admin.users.store') }}"
                class="grid grid-cols-1 md:grid-cols-4 lg:grid-cols-5 gap-4 items-end">
                @csrf
                <div class="md:col-span-1">
                    <label
                        class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1 px-1">Full
                        Name</label>
                    <input name="name" value="{{ old('name') }}"
                        class="w-full bg-white dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-indigo-500 transition-all dark:text-white"
                        placeholder="John Doe">
                    @error('name')<div class="text-[10px] text-red-600 mt-1">{{ $message }}</div>@enderror
                </div>
                <div class="md:col-span-1">
                    <label
                        class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1 px-1">Email
                        Address</label>
                    <input name="email" value="{{ old('email') }}"
                        class="w-full bg-white dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-indigo-500 transition-all dark:text-white"
                        placeholder="john@example.com">
                    @error('email')<div class="text-[10px] text-red-600 mt-1">{{ $message }}</div>@enderror
                </div>
                <div class="md:col-span-1">
                    <label
                        class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1 px-1">Password</label>
                    <input name="password" type="password"
                        class="w-full bg-white dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-indigo-500 transition-all dark:text-white"
                        placeholder="••••••••">
                    @error('password')<div class="text-[10px] text-red-600 mt-1">{{ $message }}</div>@enderror
                </div>
                <div class="md:col-span-1 lg:col-span-1">
                    <label
                        class="block text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-1 px-1">Confirm
                        Password</label>
                    <input name="password_confirmation" type="password"
                        class="w-full bg-white dark:bg-gray-900/50 border border-gray-200 dark:border-gray-700 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-indigo-500 transition-all dark:text-white"
                        placeholder="••••••••">
                </div>
                <div class="md:col-span-4 lg:col-span-1">
                    <button
                        class="w-full bg-indigo-600 hover:bg-indigo-500 text-white font-bold py-2.5 rounded-xl transition-all shadow-lg shadow-indigo-500/20 active:scale-[0.98]">
                        Create Account
                    </button>
                </div>
            </form>
        </div>

        <!-- Users Table -->
        <div
            class="bg-white/60 dark:bg-gray-800/60 backdrop-blur-md rounded-2xl shadow-sm border border-white/20 dark:border-gray-700/50 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead
                        class="bg-gray-50/50 dark:bg-gray-900/30 text-xs font-bold text-gray-500 dark:text-gray-400 uppercase tracking-widest border-b border-gray-100 dark:border-gray-700">
                        <tr>
                            <th class="px-6 py-4">User Details</th>
                            <th class="px-6 py-4 text-center">Current Role</th>
                            <th class="px-6 py-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                        @foreach($users as $user)
                            <tr class="hover:bg-gray-50/50 dark:hover:bg-white/5 transition-colors group">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 rounded-full bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center text-white font-bold text-sm shadow-sm ring-2 ring-white dark:ring-gray-800 transition-transform group-hover:scale-105">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="font-bold text-gray-900 dark:text-white">{{ $user->name }}</div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">{{ $user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <form method="POST" action="{{ route('admin.users.update', $user) }}"
                                        class="flex items-center justify-center gap-2">
                                        @csrf
                                        @method('PATCH')
                                        <select name="role"
                                            class="bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 text-xs rounded-lg px-3 py-1.5 focus:ring-1 focus:ring-indigo-500 transition-all dark:text-white">
                                            <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>Student/User
                                            </option>
                                            <option value="teacher" {{ $user->role === 'teacher' ? 'selected' : '' }}>Teacher
                                            </option>
                                            <option value="editor" {{ $user->role === 'editor' ? 'selected' : '' }}>Editor
                                            </option>
                                            <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                        </select>
                                        <button
                                            class="p-1.5 rounded-lg bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 hover:bg-indigo-100 dark:hover:bg-indigo-900/50 transition-all active:scale-90"
                                            title="Update Role">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </button>
                                    </form>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    @if($user->role === 'teacher' && $user->id !== auth()->id())
                                        <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
                                            class="inline-block delete-teacher-form"
                                            onsubmit="return confirm('Delete this teacher account? This will unassign their modules.')">
                                            @csrf
                                            @method('DELETE')
                                            <button
                                                class="p-2 rounded-xl bg-red-50 dark:bg-red-900/10 text-red-500 hover:bg-red-100 dark:hover:bg-red-900/30 transition-all"
                                                title="Delete Account">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                    </path>
                                                </svg>
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-[10px] text-gray-400 dark:text-gray-600 italic">No actions
                                            available</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            document.querySelectorAll('.delete-teacher-form').forEach(form => {
                form.addEventListener('submit', async function (e) {
                    e.preventDefault();
                    if (!confirm('Delete this teacher account? This will unassign their modules.')) return;
                    const action = this.getAttribute('action');
                    try {
                        const res = await fetch(action, {
                            method: 'DELETE',
                            headers: {
                                'Accept': 'application/json',
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': token,
                            }
                        });

                        if (!res.ok) {
                            const err = await res.json().catch(() => null);
                            alert(err?.message || 'Failed to delete teacher');
                            return;
                        }

                        // remove row from DOM
                        this.closest('tr').remove();
                    } catch (e) {
                        console.error(e);
                        alert('Network error');
                    }
                });
            });
        });
    </script>

@endsection