@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 rounded shadow">
    <h1 class="text-xl font-bold mb-4">Module: {{ $module->code }}</h1>

    <div class="mb-4">
        <div class="text-sm text-gray-600">Name</div>
        <div class="font-medium">{{ $module->name }}</div>
    </div>

    <div class="mb-4">
        <div class="text-sm text-gray-600">Status</div>
        <div class="font-medium">{{ $module->is_archived ? 'Archived' : 'Active' }}</div>
    </div>

    <div class="flex gap-2">
        <a href="{{ route('modules.edit', $module) }}" class="px-4 py-2 rounded border">Edit</a>
        @can('assignTeacher', $module)
            <a href="{{ route('admin.modules.teacher.edit', $module) }}" class="px-4 py-2 rounded border">Assign Teacher</a>
        @endcan

        <form method="POST" action="{{ route('modules.destroy', $module) }}" onsubmit="return confirm('Delete this module?')">
            @csrf
            @method('DELETE')
            <button class="text-red-600 underline">Delete</button>
        </form>

        <a href="{{ route('modules.index') }}" class="px-4 py-2 rounded border">Back</a>
    </div>

    @auth
        <div class="mt-4">
            @if(auth()->user()->enrolments()->where('module_id', $module->id)->exists())
                <div class="text-sm text-green-700">You are enrolled in this module.</div>
            @else
                @if($module->is_archived)
                    <div class="text-sm text-red-600">This module is archived and not available for enrolment.</div>
                @elseif($module->activeStudentsCount() >= 10)
                    <div class="text-sm text-red-600">This module is full.</div>
                @elseif(auth()->user()->activeEnrolmentsCount() >= 4)
                    <div class="text-sm text-red-600">You are at your maximum of 4 active modules.</div>
                @else
                    <form method="POST" action="{{ route('modules.enrol', $module) }}">
                        @csrf
                        <button class="px-4 py-2 bg-indigo-600 text-white rounded">Enrol on this module</button>
                    </form>
                @endif
            @endif
        </div>
    @endauth
</div>
@endsection