@extends('layouts.app')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold">Modules</h1>
        <p class="text-sm text-gray-500">Manage your course modules</p>
    </div>

    <div class="flex items-center gap-4">
        <form method="GET" action="{{ route('modules.index') }}" class="flex gap-2">
            <input name="q" value="{{ request('q') }}"
                   class="border rounded px-3 py-2" 
                   placeholder="Search by code or name...">
            <button class="border rounded px-4 py-2 bg-white hover:bg-gray-50">Search</button>
        </form>

        @can('create', App\Models\Module::class)
            <a href="{{ route('modules.create') }}"
               class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Create Module
            </a>
        @endcan
    </div>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
    @forelse($modules as $module)
        <div>
            @include('modules._card', ['module' => $module])
        </div>
    @empty
        <div class="col-span-1">
            <div class="bg-white p-6 rounded shadow text-center text-gray-500">No modules found.</div>
        </div>
    @endforelse
</div>

<div class="mt-6">
    {{ $modules->links() }}
</div>
@endsection
