<?php

namespace App\Http\Controllers;

use App\Models\Enrolment;
use App\Models\Module;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnrolmentController extends Controller
{
    /**
     * Enrol the current user into a module.
     */
    public function store(Request $request, Module $module): RedirectResponse
    {
        $user = Auth::user();

        // Check module availability
        if ($module->is_archived) {
            return back()->with('error', 'Module is not available for enrolment.');
        }

        // Max students per module
        if ($module->activeStudentsCount() >= 10) {
            return back()->with('error', 'This module is full.');
        }

        // Max modules per student (active)
        if ($user->activeEnrolmentsCount() >= 4) {
            return back()->with('error', 'You are already enrolled in the maximum number of active modules.');
        }

        // Prevent duplicate enrolment
        if ($user->enrolments()->where('module_id', $module->id)->exists()) {
            return back()->with('error', 'You are already enrolled in this module.');
        }

        $enrolment = Enrolment::create([
            'user_id' => $user->id,
            'module_id' => $module->id,
            'started_at' => now(),
            'status' => Enrolment::STATUS_PENDING,
        ]);

        return redirect()->route('modules.show', $module)->with('status', 'Enrolled successfully.');
    }
}
