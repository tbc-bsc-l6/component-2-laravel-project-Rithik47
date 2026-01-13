<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\User;
use App\Models\Enrolment;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $data = [
            'user' => $user,
            'role' => $user->role,
        ];

        // Admin dashboard data
        if ($user->isAdmin()) {
            $data['stats'] = [
                'total_modules' => Module::count(),
                'active_modules' => Module::where('is_archived', false)->count(),
                'total_users' => User::count(),
                'total_teachers' => User::where('role', 'teacher')->count(),
                'total_students' => User::where('role', 'user')->count(),
                'total_enrolments' => Enrolment::whereNull('completed_at')->count(),
            ];
            $data['recent_modules'] = Module::with('teacher')->latest()->take(5)->get();
            $data['recent_users'] = User::latest()->take(5)->get();
        }

        // Teacher dashboard data
        if ($user->role === 'teacher') {
            $data['my_modules'] = Module::where('teacher_id', $user->id)
                ->withCount(['enrolments as active_students_count' => function ($q) {
                    $q->whereNull('completed_at');
                }])
                ->get();
            $data['total_students'] = Enrolment::whereHas('module', function ($q) use ($user) {
                $q->where('teacher_id', $user->id);
            })->whereNull('completed_at')->count();
        }

        // Student dashboard data
        if (in_array($user->role, ['user', 'old_student'])) {
            $data['current_enrolments'] = $user->enrolments()
                ->whereNull('completed_at')
                ->with('module')
                ->get();
            $data['completed_enrolments'] = $user->enrolments()
                ->whereNotNull('completed_at')
                ->with('module')
                ->latest('completed_at')
                ->take(5)
                ->get();
            $data['available_modules'] = Module::where('is_archived', false)
                ->whereDoesntHave('enrolments', function ($q) use ($user) {
                    $q->where('user_id', $user->id);
                })
                ->get()
                ->filter(function ($m) {
                    return $m->activeStudentsCount() < 10;
                })
                ->take(5);
        }

        return view('dashboard', $data);
    }
}

