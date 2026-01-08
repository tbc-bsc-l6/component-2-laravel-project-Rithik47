<?php

namespace App\Policies;

use App\Models\Enrolment;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EnrolmentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the teacher can grade the enrolment.
     */
    public function grade(User $user, Enrolment $enrolment): bool
    {
        // only teachers assigned to the module can grade
        return $user->role === 'teacher' && $enrolment->module && $enrolment->module->teacher_id === $user->id;
    }
}
