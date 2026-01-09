@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto space-y-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Profile Settings</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">Manage your account information and security</p>
        </div>

        <div class="space-y-6">
            <div
                class="p-6 sm:p-8 bg-white/60 dark:bg-gray-800/60 backdrop-blur-md shadow-sm border border-white/20 dark:border-gray-700/50 rounded-2xl">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div
                class="p-6 sm:p-8 bg-white/60 dark:bg-gray-800/60 backdrop-blur-md shadow-sm border border-white/20 dark:border-gray-700/50 rounded-2xl">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div
                class="p-6 sm:p-8 bg-white/60 dark:bg-gray-800/60 backdrop-blur-md shadow-sm border border-white/20 dark:border-gray-700/50 rounded-2xl">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
@endsection