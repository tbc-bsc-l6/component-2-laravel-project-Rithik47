@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto bg-white p-6 rounded shadow">
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-xl font-bold">Manage Students — {{ $module->code }} {{ $module->name }}</h1>
        <a href="{{ route('admin.modules.index') }}" class="text-sm hover:underline">Back</a>
    </div>

    <h2 class="text-lg font-medium">Assigned Teacher</h2>
    <div class="mb-4">{{ $module->teacher?->name ?? '— Unassigned' }}</div>

    <h2 class="text-lg font-medium">Active Students</h2>
    @if($module->enrolments->isEmpty())
        <div class="text-sm text-gray-600">No active students.</div>
    @else
        <ul class="mt-2 space-y-2">
            @foreach($module->enrolments as $enrol)
                <li class="p-3 border rounded flex justify-between items-center">
                    <div>
                        <div class="font-medium">{{ $enrol->user->name }} ({{ $enrol->user->email }})</div>
                        <div class="text-sm text-gray-600">Enrolled: {{ optional($enrol->started_at)->toDateString() }}</div>
                    </div>
                    <form method="POST" action="{{ route('admin.modules.students.destroy', [$module, $enrol]) }}" onsubmit="return confirm('Remove this student from module?')">
                        @csrf
                        @method('DELETE')
                        <button class="px-3 py-1 rounded bg-red-600 text-white">Remove</button>
                    </form>
                </li>
            @endforeach
        </ul>
    @endif
</div>
@endsection
