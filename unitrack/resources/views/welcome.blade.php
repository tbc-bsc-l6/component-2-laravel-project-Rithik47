<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Sign in — Unitrack</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="bg-gray-50 dark:bg-gray-900 min-h-screen flex items-center justify-center">
    <div class="max-w-4xl mx-auto p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-center">
            <div class="hidden md:flex items-center justify-center bg-gradient-to-tr from-indigo-600 to-indigo-400 rounded-lg p-8 text-white">
                <div class="text-center">
                    <svg class="mx-auto h-12 w-12" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden>
                        <path d="M12 2L20 6v6c0 6-8 10-8 10s-8-4-8-10V6l8-4z" fill="currentColor"/>
                    </svg>
                    <h2 class="mt-4 text-2xl font-semibold">Welcome to Unitrack</h2>
                    <p class="mt-2 text-sm opacity-90">Manage modules, enrollments and users — securely and simply.</p>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                <div x-data="{ tab: 'login' }" class="space-y-4">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <button :class="tab==='login' ? 'border-b-2 border-indigo-600 pb-1 text-indigo-700' : 'text-gray-600 dark:text-gray-300'" x-on:click="tab='login'">Log in</button>
                            <button :class="tab==='register' ? 'border-b-2 border-indigo-600 pb-1 text-indigo-700' : 'text-gray-600 dark:text-gray-300'" x-on:click="tab='register'">Register</button>
                        </div>
                        <div class="text-sm text-gray-500">Need help? <a href="/" class="text-indigo-600 hover:underline">Contact</a></div>
                    </div>

                    <!-- messages -->
                    @if(session('status'))
                        <div class="p-2 text-sm text-green-700 bg-green-100 rounded">{{ session('status') }}</div>
                    @endif
                    @if(session('error'))
                        <div class="p-2 text-sm text-red-700 bg-red-100 rounded">{{ session('error') }}</div>
                    @endif

                    <!-- Login -->
                    <div x-show="tab==='login'">
                        <form method="POST" action="{{ route('login') }}" class="space-y-4">
                            @csrf
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Email</label>
                                <input name="email" type="email" required autofocus class="mt-1 block w-full rounded border-gray-200 dark:border-gray-700" value="{{ old('email') }}">
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Password</label>
                                <input name="password" type="password" required class="mt-1 block w-full rounded border-gray-200 dark:border-gray-700">
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>

                            <div class="flex items-center justify-between">
                                <label class="inline-flex items-center text-sm text-gray-600 dark:text-gray-300">
                                    <input type="checkbox" name="remember" class="form-checkbox">
                                    <span class="ms-2">Remember me</span>
                                </label>

                                @if (Route::has('password.request'))
                                    <a class="text-sm text-indigo-600 hover:underline" href="{{ route('password.request') }}">Forgot?</a>
                                @endif
                            </div>

                            <div>
                                <button type="submit" class="w-full inline-flex justify-center items-center gap-2 px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700"> 
                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none"><path d="M5 12h14" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                                    Log in
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Register -->
                    <div x-show="tab==='register'" x-cloak>
                        <form method="POST" action="{{ route('register') }}" class="space-y-4" x-data="{ admin:false }">
                            @csrf
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Name</label>
                                <input name="name" type="text" required class="mt-1 block w-full rounded border-gray-200 dark:border-gray-700" value="{{ old('name') }}">
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Email</label>
                                <input name="email" type="email" required class="mt-1 block w-full rounded border-gray-200 dark:border-gray-700" value="{{ old('email') }}">
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Password</label>
                                    <input name="password" type="password" required class="mt-1 block w-full rounded border-gray-200 dark:border-gray-700">
                                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">Confirm</label>
                                    <input name="password_confirmation" type="password" required class="mt-1 block w-full rounded border-gray-200 dark:border-gray-700">
                                </div>
                            </div>

                            <div>
                                <button type="button" x-on:click="admin = !admin" class="text-sm text-indigo-600 hover:underline"> <span x-text="admin ? 'Hide invite' : 'Have an admin invite?'"></span></button>
                                <div x-show="admin" x-cloak class="mt-2">
                                    <input name="invite_token" type="text" placeholder="Invite token" class="mt-1 block w-full rounded border-gray-200 dark:border-gray-700" value="{{ old('invite_token') }}">
                                    <x-input-error :messages="$errors->get('invite_token')" class="mt-2" />
                                </div>
                            </div>

                            <div>
                                <button type="submit" class="w-full inline-flex justify-center items-center gap-2 px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700"> 
                                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none"><path d="M5 12h14" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                                    Create account
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
