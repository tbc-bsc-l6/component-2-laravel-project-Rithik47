@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto bg-white p-6 rounded shadow">
    <h1 class="text-xl font-bold mb-4">Manage Users</h1>

    @if(session('success'))
        <div x-data x-init="setTimeout(()=> $el.remove(), 3000)" class="mb-4 rounded bg-green-100 text-green-800 px-4 py-3">
            {{ session('success') }}
        </div>
    @endif

    <div class="mb-6 p-4 bg-gray-50 rounded">
        <h2 class="text-lg font-medium mb-2">Create Teacher</h2>
        <form method="POST" action="{{ route('admin.users.store') }}" class="grid grid-cols-1 md:grid-cols-4 gap-2 items-end">
            @csrf
            <div>
                <label class="block text-sm">Name</label>
                <input name="name" value="{{ old('name') }}" class="mt-1 block w-full rounded border-gray-200 px-2 py-1">
                @error('name')<div class="text-xs text-red-600">{{ $message }}</div>@enderror
            </div>
            <div>
                <label class="block text-sm">Email</label>
                <input name="email" value="{{ old('email') }}" class="mt-1 block w-full rounded border-gray-200 px-2 py-1">
                @error('email')<div class="text-xs text-red-600">{{ $message }}</div>@enderror
            </div>
            <div>
                <label class="block text-sm">Password</label>
                <input name="password" type="password" class="mt-1 block w-full rounded border-gray-200 px-2 py-1">
                @error('password')<div class="text-xs text-red-600">{{ $message }}</div>@enderror
            </div>

            <div>
                <label class="block text-sm">Confirm Password</label>
                <input name="password_confirmation" type="password" class="mt-1 block w-full rounded border-gray-200 px-2 py-1">
                @error('password_confirmation')<div class="text-xs text-red-600">{{ $message }}</div>@enderror
            </div>
            <div>
                <label class="block text-sm">&nbsp;</label>
                <button class="w-full px-3 py-1 rounded bg-green-600 text-white">Create Teacher</button>
            </div>
        </form>
    </div>

    <table class="w-full text-sm">
        <thead>
            <tr class="text-left text-gray-600">
                <th class="pb-2">Name</th>
                <th class="pb-2">Email</th>
                <th class="pb-2">Role</th>
                <th class="pb-2"></th>
            </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
            <tr class="border-t">
                <td class="py-3">{{ $user->name }}</td>
                <td class="py-3">{{ $user->email }}</td>
                <td class="py-3">
                    <form method="POST" action="{{ route('admin.users.update', $user) }}">
                        @csrf
                        @method('PATCH')
                        <select name="role" class="border rounded px-2 py-1">
                            <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>User</option>
                            <option value="teacher" {{ $user->role === 'teacher' ? 'selected' : '' }}>Teacher</option>
                            <option value="editor" {{ $user->role === 'editor' ? 'selected' : '' }}>Editor</option>
                            <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                        <button class="ml-2 px-3 py-1 rounded bg-blue-600 text-white">Save</button>
                    </form>
                </td>
                <td class="py-3">
                    @if($user->role === 'teacher' && $user->id !== auth()->id())
                        <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="inline-block delete-teacher-form" onsubmit="return confirm('Delete this teacher account? This will unassign their modules.')">
                            @csrf
                            @method('DELETE')
                            <button class="px-3 py-1 rounded bg-red-600 text-white">Delete</button>
                        </form>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
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
                    const err = await res.json().catch(()=>null);
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