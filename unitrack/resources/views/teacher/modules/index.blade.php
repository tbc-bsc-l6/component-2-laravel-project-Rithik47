@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto bg-white p-6 rounded shadow">
    <h1 class="text-xl font-bold mb-4">Your Modules</h1>

    @if($modules->isEmpty())
        <div class="text-sm text-gray-600">You have no modules assigned.</div>
    @else
        <ul class="space-y-3">
            @foreach($modules as $m)
                <li class="p-3 border rounded flex justify-between items-center">
                    <div>
                        <div class="font-medium">{{ $m->code }} — {{ $m->name }}</div>
                        <div class="text-sm text-gray-500">Active students: {{ $m->active_students_count }}</div>
                    </div>
                    <a href="{{ route('teacher.modules.show', $m) }}" class="text-indigo-600 hover:underline">View students</a>
                </li>
            @endforeach
        </ul>
    @endif
</div>
@endsection
