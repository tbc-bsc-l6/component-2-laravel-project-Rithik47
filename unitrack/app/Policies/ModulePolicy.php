<?php

namespace App\Policies;

use App\Models\Module;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ModulePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any modules.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the module.
     */
    public function view(User $user, Module $module): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create modules.
     */
    public function create(User $user): bool
    {
        // editors and admins can create
        return in_array($user->role, ['editor', 'admin']);
    }

    /**
     * Determine whether the user can update the module.
     */
    public function update(User $user, Module $module): bool
    {
        // editors and admins can update
        return in_array($user->role, ['editor', 'admin']);
    }

    /**
     * Determine whether the user can delete the module.
     */
    public function delete(User $user, Module $module): bool
    {
        // only admins can delete
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can assign a teacher to the module.
     */
    public function assignTeacher(User $user, Module $module): bool
    {
        return $user->isAdmin();
    }
}