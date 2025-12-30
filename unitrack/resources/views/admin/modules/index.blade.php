@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto bg-white p-6 rounded shadow">
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-xl font-bold">Manage Modules</h1>
        <div class="text-sm text-gray-600">Total: {{ $modules->total() }}</div>
    </div>

    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="text-sm text-gray-600 border-b">
                <th class="py-2">Code</th>
                <th class="py-2">Name</th>
                <th class="py-2">Teacher</th>
                <th class="py-2">Active Students</th>
                <th class="py-2">Status</th>
                <th class="py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($modules as $mod)
                <tr class="border-b hover:bg-gray-50">
                    <td class="py-3">{{ $mod->code }}</td>
                    <td class="py-3">{{ $mod->name }}</td>
                    <td class="py-3">
                        <select data-module-id="{{ $mod->id }}" name="teacher_id" class="teacher-select rounded border-gray-200">
                            <option value="">-- Unassigned --</option>
                            @foreach($teachers as $t)
                                <option value="{{ $t->id }}" @if($mod->teacher_id === $t->id) selected @endif>{{ $t->name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td class="py-3">{{ $mod->active_students_count }}</td>
                    <td class="py-3">{{ $mod->is_archived ? 'Archived' : 'Active' }}</td>
                    <td class="py-3">
                        <a href="{{ route('modules.show', $mod) }}" class="text-sm ms-2 hover:underline">View</a>
                        <a href="{{ route('admin.modules.show', $mod) }}" class="text-sm ms-2 hover:underline">Manage students</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="mt-4">{{ $modules->links() }}</div>
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
