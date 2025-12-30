<!DOCTYPE html>
<html lang="{{ str_replace('_','-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'UniTrack') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 text-gray-900">
    <div class="min-h-screen">
        {{-- Top Nav --}}
        <nav class="bg-white border-b">
            <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">
                <a href="{{ route('dashboard') }}" class="font-bold text-xl">UniTrack</a>

                <div class="flex gap-4 items-center">
                    <a class="text-sm hover:underline" href="{{ route('modules.index') }}">Modules</a>

                    @auth
                        <div class="text-sm text-gray-600">Role: <span class="font-medium">{{ auth()->user()->role }}</span></div>

                        @if(auth()->user()->isAdmin())
                            <a class="text-sm hover:underline" href="{{ route('admin.users.index') }}">Manage Users</a>
                            <a class="text-sm hover:underline ms-3" href="{{ route('admin.modules.index') }}">Manage Modules</a>
                        @endif
                        @if(auth()->user()->role === 'teacher')
                            <a class="text-sm hover:underline ms-3" href="{{ route('teacher.modules.index') }}">Teacher Dashboard</a>
                        @endif

                        @if(in_array(auth()->user()->role, ['user', 'old_student']))
                            <a class="text-sm hover:underline ms-3" href="{{ route('student.dashboard') }}">Student Dashboard</a>
                        @endif
                    @endauth

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="text-sm text-red-600 hover:underline">Logout</button>
                    </form>
                </div>
            </div>
        </nav>

        {{-- Page Container --}}
        <main class="max-w-7xl mx-auto px-4 py-6">
            @if(session('success'))
                <div x-data="{show: true}" x-show="show" x-init="setTimeout(()=> show = false, 3500)" x-transition class="mb-4 rounded bg-green-100 text-green-800 px-4 py-3">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div x-data="{show: true}" x-show="show" x-init="setTimeout(()=> show = false, 3500)" x-transition class="mb-4 rounded bg-red-100 text-red-800 px-4 py-3">
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</body>
</html>
