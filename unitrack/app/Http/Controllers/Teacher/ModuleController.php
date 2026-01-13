<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Module;
use App\Models\Enrolment;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        if ($user->role !== 'teacher') {
            abort(403);
        }

        $modules = Module::where('teacher_id', $user->id)->withCount(['enrolments as active_students_count' => function ($q) {
            $q->whereNull('completed_at');
        }])->get();

        return view('teacher.modules.index', compact('modules'));
    }

    public function show(Module $module)
    {
        $user = auth()->user();
        if ($user->role !== 'teacher' || $module->teacher_id !== $user->id) {
            abort(403);
        }

        $students = $module->enrolments()->with('user')->get();

        return view('teacher.modules.show', compact('module', 'students'));
    }

    public function grade(Request $request, Module $module, Enrolment $enrolment)
    {
        $this->authorize('grade', $enrolment);

        $request->validate(['status' => ['required', 'in:pass,fail']]);

        $enrolment->status = $request->input('status');
        $enrolment->completed_at = now();
        $enrolment->save();

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Student graded.', 'status' => $enrolment->status]);
        }

        return redirect()->route('teacher.modules.show', $module)->with('status', 'Student graded.');
    }
}
