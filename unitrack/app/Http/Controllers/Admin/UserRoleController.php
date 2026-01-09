<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Module;

class UserRoleController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', User::class);

        $users = User::orderBy('name')->get();

        return view('admin.users.index', compact('users'));
    }

    public function update(Request $request, User $user)
    {
        $this->authorize('updateRole', $user);

        $data = $request->validate([
            'role' => 'required|in:user,teacher,editor,admin',
        ]);

        $user->update(['role' => $data['role']]);

        return redirect()->route('admin.users.index')->with('success', 'User role updated.');
    }

    public function store(Request $request)
    {
        $this->authorize('create', User::class);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => \Illuminate\Support\Facades\Hash::make($data['password']),
            'role' => 'teacher',
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Teacher account created.');
    }

    public function destroy(Request $request, User $user)
    {
        // Only admins
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }

        // prevent deleting self
        if (auth()->id() === $user->id) {
            abort(400, 'Cannot delete yourself.');
        }

        // cannot delete an admin
        if ($user->isAdmin()) {
            abort(403);
        }

        // only teachers may be deleted here
        if ($user->role !== 'teacher') {
            abort(400, 'Only teacher accounts may be deleted.');
        }

        DB::transaction(function () use ($user) {
            // unassign modules
            Module::where('teacher_id', $user->id)->update(['teacher_id' => null]);
            $user->delete();
        });

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Teacher deleted']);
        }

        return redirect()->route('admin.users.index')->with('success', 'Teacher account deleted.');
    }
}