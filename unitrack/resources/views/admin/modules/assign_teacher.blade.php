@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
    <h1 class="text-xl font-bold mb-4">Assign Teacher — {{ $module->code }}</h1>

    <form method="POST" action="{{ route('admin.modules.teacher.update', $module) }}">
        @csrf
        @method('PATCH')

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Teacher</label>
            <select name="teacher_id" class="mt-1 block w-full rounded border-gray-200">
                <option value="">-- Unassigned --</option>
                @foreach($teachers as $t)
                    <option value="{{ $t->id }}" @if($module->teacher_id === $t->id) selected @endif>{{ $t->name }} &lt;{{ $t->email }}&gt;</option>
                @endforeach
            </select>
        </div>

        <div class="flex gap-2">
            <button class="px-4 py-2 bg-indigo-600 text-white rounded">Save</button>
            <a href="{{ route('modules.show', $module) }}" class="px-4 py-2 rounded border">Cancel</a>
        </div>
    </form>
</div>
@endsection
