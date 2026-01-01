@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto bg-white p-6 rounded shadow">
    <h1 class="text-xl font-bold mb-4">Students — {{ $module->code }}: {{ $module->name }}</h1>

    @if(session('status'))
        <div class="mb-4 text-sm text-green-700">{{ session('status') }}</div>
    @endif

    @if($students->isEmpty())
        <div class="text-sm text-gray-600">No students enrolled.</div>
    @else
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="text-sm text-gray-600 border-b">
                    <th class="py-2">Student</th>
                    <th class="py-2">Status</th>
                    <th class="py-2">Started</th>
                    <th class="py-2">Completed</th>
                    <th class="py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($students as $enrol)
                    <tr class="border-b hover:bg-gray-50" data-enrol-id="{{ $enrol->id }}">
                        <td class="py-3">{{ $enrol->user->name }} &lt;{{ $enrol->user->email }}&gt;</td>
                        <td class="py-3 enrol-status">{{ ucfirst($enrol->status) }}</td>
                        <td class="py-3 enrol-started">{{ optional($enrol->started_at)->toDateString() }}</td>
                        <td class="py-3 enrol-completed">{{ optional($enrol->completed_at)->toDateString() }}</td>
                        <td class="py-3 enrol-actions">
                            @can('grade', $enrol)
                                <form method="POST" action="{{ route('teacher.modules.enrolments.grade', [$module, $enrol]) }}" class="inline-block grade-form">
                                    @csrf
                                    <input type="hidden" name="status" value="pass">
                                    <button class="px-3 py-1 text-sm bg-green-600 text-white rounded">Pass</button>
                                </form>

                                <form method="POST" action="{{ route('teacher.modules.enrolments.grade', [$module, $enrol]) }}" class="inline-block ms-2 grade-form">
                                    @csrf
                                    <input type="hidden" name="status" value="fail">
                                    <button class="px-3 py-1 text-sm bg-red-600 text-white rounded">Fail</button>
                                </form>
                            @else
                                <span class="text-sm text-gray-500">No actions</span>
                            @endcan
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

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
                    // update row
                    row.querySelector('.enrol-status').textContent = data.status.toUpperCase();
                    row.querySelector('.enrol-completed').textContent = new Date().toISOString().slice(0,10);
                    // remove actions
                    row.querySelector('.enrol-actions').innerHTML = '<span class="text-sm text-gray-500">No actions</span>';

                    toast('Student graded');
                } catch (e) {
                    console.error(e);
                    toast('Network error', false);
                }
            });
        });
    });
    </script>

</div>
@endsection
