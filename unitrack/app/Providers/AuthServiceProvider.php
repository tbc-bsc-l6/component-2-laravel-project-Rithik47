<?php

namespace App\Providers;

use App\Models\Module;
use App\Policies\ModulePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Module::class => ModulePolicy::class,
        \App\Models\User::class => \App\Policies\UserPolicy::class,
        \App\Models\Enrolment::class => \App\Policies\EnrolmentPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}