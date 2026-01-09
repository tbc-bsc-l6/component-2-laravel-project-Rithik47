<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Module;
use App\Models\Enrolment;
use Illuminate\Http\Request;

class ModuleAdminController extends Controller
{
    public function index()
    {
        // Only admins may access this admin listing
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $modules = Module::with('teacher')->withCount(['enrolments as active_students_count' => function ($q) {
            $q->whereNull('completed_at');
        }])->paginate(15);

        $teachers = \App\Models\User::where('role', 'teacher')->get();

        return view('admin.modules.index', compact('modules', 'teachers'));
    }

    public function show(Module $module)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        $module->load(['enrolments' => function ($q) {
            $q->whereNull('completed_at')->with('user');
        }, 'teacher']);

        return view('admin.modules.show', compact('module'));
    }

    public function removeStudent(Request $request, Module $module, Enrolment $enrolment)
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        // ensure the enrolment belongs to the module
        if ($enrolment->module_id !== $module->id) {
            abort(400);
        }

        $enrolment->delete();

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Student removed']);
        }

        return redirect()->route('admin.modules.show', $module)->with('status', 'Student removed from module.');
    }
}

