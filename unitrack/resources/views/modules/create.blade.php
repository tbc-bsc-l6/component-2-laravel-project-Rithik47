@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto bg-white p-6 rounded shadow">
    <h1 class="text-xl font-bold mb-4">Create Module</h1>

    @if($errors->any())
        <div class="mb-4 text-red-700">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('modules.store') }}" class="space-y-4">
        @csrf

        <div>
            <label class="block text-sm font-medium">Code</label>
            <input name="code" value="{{ old('code') }}" class="w-full border rounded px-3 py-2" required>
        </div>

        <div>
            <label class="block text-sm font-medium">Name</label>
            <input name="name" value="{{ old('name') }}" class="w-full border rounded px-3 py-2" required>
        </div>

        <div class="flex items-center gap-2">
            <input type="checkbox" name="is_archived" id="is_archived" value="1" {{ old('is_archived') ? 'checked' : '' }}>
            <label for="is_archived" class="text-sm">Archived</label>
        </div>

        <div class="flex gap-2">
            <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Create</button>
            <a href="{{ route('modules.index') }}" class="px-4 py-2 rounded border">Cancel</a>
        </div>
    </form>
</div>
@endsection