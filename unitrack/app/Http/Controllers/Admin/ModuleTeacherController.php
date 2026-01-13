<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Module;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ModuleTeacherController extends Controller
{
    public function edit(Module $module)
    {
        $this->authorize('assignTeacher', $module);

        $teachers = User::where('role', 'teacher')->get();

        return view('admin.modules.assign_teacher', compact('module', 'teachers'));
    }

    public function update(Request $request, Module $module)
    {
        $this->authorize('assignTeacher', $module);

        $request->validate([
            'teacher_id' => ['nullable', 'exists:users,id'],
        ]);

        $module->teacher_id = $request->input('teacher_id');
        $module->save();

        // If request expects JSON (AJAX), return a JSON response for optimistic UI
        if ($request->expectsJson()) {
            return response()->json([
                'status' => 'ok',
                'teacher' => $module->teacher ? ['id' => $module->teacher->id, 'name' => $module->teacher->name] : null,
            ]);
        }

        return redirect()->route('admin.modules.index')->with('status', 'Teacher assignment updated.');
    }
}
