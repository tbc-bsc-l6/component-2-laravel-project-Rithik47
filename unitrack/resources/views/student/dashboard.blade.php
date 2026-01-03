@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto bg-white p-6 rounded shadow">
    <h1 class="text-xl font-bold mb-4">Student Dashboard</h1>

    @if(isset($current))
        <h2 class="text-lg font-medium">Current Enrolments</h2>
        @if($current->isEmpty())
            <div class="text-sm text-gray-600">You are not enrolled in any active modules.</div>
        @else
            <ul class="mt-2 space-y-2">
                @foreach($current as $enrol)
                    <li class="p-3 border rounded">
                        <div class="font-medium">{{ $enrol->module->code }} — {{ $enrol->module->name }}</div>
                        <div class="text-sm text-gray-600">Started: {{ optional($enrol->started_at)->toDateString() }}</div>
                    </li>
                @endforeach
            </ul>
        @endif
    @endif

    @if(isset($available))
        <h2 class="text-lg font-medium mt-6">Available Modules</h2>
        @if($available->isEmpty())
            <div class="text-sm text-gray-600">No available modules to enrol.</div>
        @else
            <ul class="mt-2 space-y-2">
                @foreach($available as $m)
                    <li class="p-3 border rounded flex justify-between items-center">
                        <div>
                            <div class="font-medium">{{ $m->code }} — {{ $m->name }}</div>
                            <div class="text-sm text-gray-500">Active students: {{ $m->activeStudentsCount() }} / 10</div>
                        </div>
                        <form method="POST" action="{{ route('modules.enrol', $m) }}">
                            @csrf
                            <button class="px-3 py-1 rounded bg-indigo-600 text-white">Enrol</button>
                        </form>
                    </li>
                @endforeach
            </ul>
        @endif
    @endif

    @if(isset($history))
        <h2 class="text-lg font-medium mt-6">Completed Modules</h2>
        @if($history->isEmpty())
            <div class="text-sm text-gray-600">No completed modules yet.</div>
        @else
            <ul class="mt-2 space-y-2">
                @foreach($history as $enrol)
                    <li class="p-3 border rounded">
                        <div class="font-medium">{{ $enrol->module->code }} — {{ $enrol->module->name }}</div>
                        <div class="text-sm text-gray-500">Status: {{ strtoupper($enrol->status) }} — Completed: {{ optional($enrol->completed_at)->toDateString() }}</div>
                    </li>
                @endforeach
            </ul>
        @endif
    @endif
</div>
@endsection
