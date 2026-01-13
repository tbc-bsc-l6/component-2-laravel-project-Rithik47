<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Module;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Old students see only completed modules
        $history = $user->enrolments()->whereNotNull('completed_at')->with('module')->get();

        if ($user->role === 'old_student') {
            return view('student.dashboard', compact('history'));
        }

        $current = $user->enrolments()->whereNull('completed_at')->with('module')->get();

        // Available modules: not archived, not already enrolled, and not full
        $enrolledModuleIds = $user->enrolments()->pluck('module_id')->toArray();

        $available = Module::where('is_archived', false)
            ->whereNotIn('id', $enrolledModuleIds)
            ->get()
            ->filter(function ($m) {
                return $m->activeStudentsCount() < 10;
            });

        return view('student.dashboard', compact('current', 'available', 'history'));
    }
}
