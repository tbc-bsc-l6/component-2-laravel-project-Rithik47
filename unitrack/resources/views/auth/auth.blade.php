<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Sign in — Unitrack</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @keyframes blob {
            0% {
                transform: translate(0px, 0px) scale(1);
            }

            33% {
                transform: translate(30px, -50px) scale(1.1);
            }

            66% {
                transform: translate(-20px, 20px) scale(0.9);
            }

            100% {
                transform: translate(0px, 0px) scale(1);
            }
        }

        .animate-blob {
            animation: blob 7s infinite;
        }

        .animation-delay-2000 {
            animation-delay: 2s;
        }

        .animation-delay-4000 {
            animation-delay: 4s;
        }
    </style>
</head>

<body
    class="bg-gray-900 min-h-screen flex items-center justify-center relative overflow-auto font-sans antialiased selection:bg-pink-500 selection:text-white">

    <!-- Animated Background Elements -->
    <div
        class="absolute top-0 -left-4 w-72 h-72 bg-purple-500 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob">
    </div>
    <div
        class="absolute top-0 -right-4 w-72 h-72 bg-yellow-500 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-2000">
    </div>
    <div
        class="absolute -bottom-8 left-20 w-72 h-72 bg-pink-500 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-4000">
    </div>

    <!-- Soft Gradient Overlay -->
    <div
        class="absolute inset-0 bg-gradient-to-br from-indigo-500/20 via-purple-500/20 to-pink-500/20 pointer-events-none">
    </div>

    <div class="relative w-full max-w-md px-4 z-10">
        <div
            class="bg-white/10 dark:bg-black/20 backdrop-blur-2xl rounded-2xl shadow-2xl border border-white/20 p-8 sm:p-10">

            <!-- Header -->
            <div class="text-center mb-8">
                <div
                    class="inline-flex items-center justify-center w-20 h-20 rounded-2xl bg-white/10 backdrop-blur-md border border-white/20 shadow-lg mb-4 transform hover:scale-105 transition-transform duration-300">
                    <img src="{{ asset('images/logo.png') }}" alt="Unitrack Logo" class="h-14 w-auto object-contain">
                </div>
                <h1 class="text-3xl font-bold text-white tracking-tight">Unitrack</h1>
                <p class="text-indigo-200 mt-2 text-sm font-medium">Academic Management System</p>
            </div>

            <!-- Auth Container -->
            <div x-data="{ tab: 'login' }">
                <!-- Navigation Tabs -->
                <div class="flex p-1 mb-8 bg-black/20 rounded-xl backdrop-blur-sm relative">
                    <div class="absolute inset-0 p-1 flex">
                        <div class="w-1/2 h-full bg-white/10 rounded-lg shadow-sm transition-all duration-300 ease-out transform"
                            :class="tab === 'login' ? 'translate-x-0 bg-white/20' : 'translate-x-[100%] bg-white/20'">
                        </div>
                    </div>
                    <button @click="tab = 'login'"
                        class="relative z-10 w-1/2 py-2.5 text-sm font-semibold rounded-lg transition-colors duration-200"
                        :class="tab === 'login' ? 'text-white' : 'text-indigo-200 hover:text-white'">
                        Log in
                    </button>
                    <button @click="tab = 'register'"
                        class="relative z-10 w-1/2 py-2.5 text-sm font-semibold rounded-lg transition-colors duration-200"
                        :class="tab === 'register' ? 'text-white' : 'text-indigo-200 hover:text-white'">
                        Start here
                    </button>
                </div>

                <!-- Messages -->
                @if(session('status'))
                    <div
                        class="mb-4 p-3 text-sm text-green-300 bg-green-500/20 border border-green-500/30 rounded-lg flex items-center gap-2 backdrop-blur-sm">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        {{ session('status') }}
                    </div>
                @endif
                @if(session('error'))
                    <div
                        class="mb-4 p-3 text-sm text-red-300 bg-red-500/20 border border-red-500/30 rounded-lg flex items-center gap-2 backdrop-blur-sm">
                        <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        {{ session('error') }}
                    </div>
                @endif

                <!-- Login Form -->
                <div x-show="tab === 'login'" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 -translate-y-2"
                    x-transition:enter-end="opacity-100 translate-y-0">
                    <form method="POST" action="{{ route('login') }}" class="space-y-5">
                        @csrf
                        <!-- Role Selection -->
                        <div class="space-y-2 mb-4" x-data="{ selectedRole: 'user' }">
                            <label
                                class="block text-xs font-semibold text-indigo-200 uppercase tracking-wider ml-1">Select
                                Role</label>
                            <div class="grid grid-cols-3 gap-2 p-1 bg-black/20 rounded-xl">
                                <template x-for="role in [
                                    {id: 'admin', label: 'Admin', icon: 'M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z'},
                                    {id: 'teacher', label: 'Teacher', icon: 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18 18.247 18.477 16.5 18c-1.746 0-3.332.477-4.5 1.253'},
                                    {id: 'user', label: 'Student', icon: 'M12 14l9-5-9-5-9 5 9 5z M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z'}
                                ]">
                                    <button type="button" @click="selectedRole = role.id"
                                        class="flex flex-col items-center justify-center py-2 px-1 rounded-lg transition-all duration-300 border border-transparent"
                                        :class="selectedRole === role.id ? 'bg-indigo-500/20 border-indigo-500/50 text-white shadow-lg shadow-indigo-500/10' : 'text-indigo-300 hover:bg-white/5'">
                                        <svg class="w-5 h-5 mb-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                :d="role.icon" />
                                        </svg>
                                        <span class="text-[10px] font-bold uppercase tracking-tight"
                                            x-text="role.label"></span>
                                    </button>
                                </template>
                            </div>
                            <input type="hidden" name="role" :value="selectedRole">
                            <x-input-error :messages="$errors->get('role')" class="mt-1 text-red-300 text-xs ml-1" />
                        </div>

                        <div class="space-y-1">
                            <label
                                class="block text-xs font-semibold text-indigo-200 uppercase tracking-wider ml-1">Email</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-indigo-300 group-focus-within:text-white transition-colors"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                    </svg>
                                </div>
                                <input name="email" type="email" required autofocus
                                    class="block w-full pl-10 pr-3 py-2.5 bg-black/20 border border-white/10 rounded-xl text-white placeholder-indigo-300/50 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500/50 transition-all sm:text-sm"
                                    placeholder="admin@unitrack.com" value="{{ old('email') }}">
                            </div>
                            <x-input-error :messages="$errors->get('email')" class="mt-1 text-red-300 text-xs ml-1" />
                        </div>

                        <div class="space-y-1">
                            <label
                                class="block text-xs font-semibold text-indigo-200 uppercase tracking-wider ml-1">Password</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-indigo-300 group-focus-within:text-white transition-colors"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                </div>
                                <input name="password" type="password" required
                                    class="block w-full pl-10 pr-3 py-2.5 bg-black/20 border border-white/10 rounded-xl text-white placeholder-indigo-300/50 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500/50 transition-all sm:text-sm"
                                    placeholder="••••••••">
                            </div>
                            <x-input-error :messages="$errors->get('password')"
                                class="mt-1 text-red-300 text-xs ml-1" />
                        </div>

                        <div class="flex items-center justify-between pt-1">
                            <label class="flex items-center cursor-pointer group">
                                <div class="relative">
                                    <input type="checkbox" name="remember" class="sr-only peer">
                                    <div
                                        class="block w-9 h-5 bg-black/20 rounded-full border border-white/10 peer-checked:bg-indigo-500 peer-focus:ring-2 peer-focus:ring-indigo-500/50 transition-colors">
                                    </div>
                                    <div
                                        class="dot absolute left-1 top-1 bg-indigo-200 w-3 h-3 rounded-full transition transform peer-checked:translate-x-full peer-checked:bg-white">
                                    </div>
                                </div>
                                <span
                                    class="ml-2 text-sm text-indigo-200 group-hover:text-white transition-colors">Remember
                                    me</span>
                            </label>

                            @if (Route::has('password.request'))
                                <a class="text-sm text-indigo-300 hover:text-white transition-colors decoration-indigo-500/30 hover:underline"
                                    href="{{ route('password.request') }}">
                                    Forgot password?
                                </a>
                            @endif
                        </div>

                        <button type="submit"
                            class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-lg text-sm font-bold text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transform hover:-translate-y-0.5 transition-all duration-200">
                            Sign in to Account
                        </button>

                        <div class="relative py-2">
                            <div class="absolute inset-0 flex items-center">
                                <span class="w-full border-t border-white/10"></span>
                            </div>
                            <div class="relative flex justify-center text-xs uppercase">
                                <span class="bg-gray-900 px-2 text-indigo-300">Or continue with</span>
                            </div>
                        </div>

                        <a href="{{ route('auth.google') }}"
                            class="w-full flex items-center justify-center gap-3 py-3 px-4 bg-white hover:bg-gray-100 rounded-xl shadow-md transition-all duration-200 transform hover:-translate-y-0.5 group">
                            <svg class="w-5 h-5" viewBox="0 0 24 24">
                                <path fill="#4285F4"
                                    d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                                <path fill="#34A853"
                                    d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                                <path fill="#FBBC05"
                                    d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l3.66-2.84z" />
                                <path fill="#EA4335"
                                    d="M12 5.38c1.62 0 3.06.56 4.21 1.66l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" />
                            </svg>
                            <span
                                class="text-sm font-bold text-gray-700 group-hover:text-gray-900 transition-colors">Sign
                                in with Google</span>
                        </a>
                    </form>
                </div>

                <!-- Register Form -->
                <div x-show="tab === 'register'" x-cloak x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-2"
                    x-transition:enter-end="opacity-100 translate-y-0">
                    <form method="POST" action="{{ route('register') }}" class="space-y-5" x-data="{ admin:false }">
                        @csrf
                        <div class="space-y-1">
                            <label
                                class="block text-xs font-semibold text-indigo-200 uppercase tracking-wider ml-1">Full
                                Name</label>
                            <input name="name" type="text" required
                                class="block w-full px-4 py-2.5 bg-black/20 border border-white/10 rounded-xl text-white placeholder-indigo-300/50 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500/50 transition-all sm:text-sm"
                                placeholder="John Doe" value="{{ old('name') }}">
                            <x-input-error :messages="$errors->get('name')" class="mt-1 text-red-300 text-xs ml-1" />
                        </div>

                        <div class="space-y-1">
                            <label
                                class="block text-xs font-semibold text-indigo-200 uppercase tracking-wider ml-1">Email
                                Address</label>
                            <input name="email" type="email" required
                                class="block w-full px-4 py-2.5 bg-black/20 border border-white/10 rounded-xl text-white placeholder-indigo-300/50 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500/50 transition-all sm:text-sm"
                                placeholder="you@example.com" value="{{ old('email') }}">
                            <x-input-error :messages="$errors->get('email')" class="mt-1 text-red-300 text-xs ml-1" />
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="space-y-1">
                                <label
                                    class="block text-xs font-semibold text-indigo-200 uppercase tracking-wider ml-1">Password</label>
                                <input name="password" type="password" required
                                    class="block w-full px-4 py-2.5 bg-black/20 border border-white/10 rounded-xl text-white placeholder-indigo-300/50 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500/50 transition-all sm:text-sm"
                                    placeholder="••••••••">
                                <x-input-error :messages="$errors->get('password')"
                                    class="mt-1 text-red-300 text-xs ml-1" />
                            </div>
                            <div class="space-y-1">
                                <label
                                    class="block text-xs font-semibold text-indigo-200 uppercase tracking-wider ml-1">Confirm</label>
                                <input name="password_confirmation" type="password" required
                                    class="block w-full px-4 py-2.5 bg-black/20 border border-white/10 rounded-xl text-white placeholder-indigo-300/50 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500/50 transition-all sm:text-sm"
                                    placeholder="••••••••">
                            </div>
                        </div>

                        <div>
                            <button type="button" x-on:click="admin = !admin"
                                class="text-xs font-medium text-indigo-300 hover:text-white border-b border-dashed border-indigo-400 group flex items-center gap-1 transition-colors">
                                <svg class="w-3 h-3 group-hover:rotate-90 transition-transform" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span x-text="admin ? 'Close invite options' : 'Have an admin invite?'"></span>
                            </button>
                            <div x-show="admin" x-cloak class="mt-3"
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 -translate-y-2"
                                x-transition:enter-end="opacity-100 translate-y-0">
                                <input name="invite_token" type="text"
                                    class="block w-full px-4 py-2 bg-purple-900/20 border border-purple-500/30 rounded-xl text-white placeholder-purple-300/50 focus:outline-none focus:ring-2 focus:ring-purple-500/50 focus:border-purple-500/50 transition-all sm:text-xs"
                                    placeholder="Paste your invite token here" value="{{ old('invite_token') }}">
                                <x-input-error :messages="$errors->get('invite_token')"
                                    class="mt-1 text-red-300 text-xs ml-1" />
                            </div>
                        </div>

                        <button type="submit"
                            class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-lg text-sm font-bold text-white bg-gradient-to-r from-pink-600 to-purple-600 hover:from-pink-500 hover:to-purple-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500 transform hover:-translate-y-0.5 transition-all duration-200">
                            Create Account
                        </button>

                        <div class="relative py-2">
                            <div class="absolute inset-0 flex items-center">
                                <span class="w-full border-t border-white/10"></span>
                            </div>
                            <div class="relative flex justify-center text-xs uppercase">
                                <span class="bg-gray-900 px-2 text-indigo-300">Or continue with</span>
                            </div>
                        </div>

                        <a href="{{ route('auth.google') }}"
                            class="w-full flex items-center justify-center gap-3 py-3 px-4 bg-white hover:bg-gray-100 rounded-xl shadow-md transition-all duration-200 transform hover:-translate-y-0.5 group">
                            <svg class="w-5 h-5" viewBox="0 0 24 24">
                                <path fill="#4285F4"
                                    d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                                <path fill="#34A853"
                                    d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                                <path fill="#FBBC05"
                                    d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l3.66-2.84z" />
                                <path fill="#EA4335"
                                    d="M12 5.38c1.62 0 3.06.56 4.21 1.66l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" />
                            </svg>
                            <span
                                class="text-sm font-bold text-gray-700 group-hover:text-gray-900 transition-colors">Sign
                                up with Google</span>
                        </a>
                    </form>
                </div>
            </div>

            <div class="mt-8 text-center">
                <p class="text-xs text-indigo-300 opacity-60">
                    &copy; {{ date('Y') }} Unitrack. Secure Access System.
                </p>
            </div>
        </div>
    </div>
</body>

</html>