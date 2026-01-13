<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can create new users (used for admin creating teachers).
     */
    public function create(User $user): bool
    {
        return $user->isAdmin();
    }

    public function updateRole(User $user, User $model): bool
    {
        return $user->isAdmin();
    }
}