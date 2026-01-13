<?php

namespace App\Http\Controllers;

use App\Models\Module;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('viewAny', Module::class);
        $query = Module::query();

        if ($q = $request->get('q')) {
            $query->where('code', 'like', "%{$q}%")
                  ->orWhere('name', 'like', "%{$q}%");
        }

        $modules = $query->orderBy('code')->paginate(10)->withQueryString();

        return view('modules.index', compact('modules'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Module::class);

        return view('modules.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Module::class);

        $data = $request->validate([
            'code' => 'required|string|max:50|unique:modules,code',
            'name' => 'required|string|max:255',
            'is_archived' => 'nullable|boolean',
        ]);

        // Ensure a boolean value exists for the column
        $data['is_archived'] = (bool) ($request->has('is_archived') && $request->boolean('is_archived'));

        Module::create($data);

        return redirect()->route('modules.index')->with('success', 'Module created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Module $module)
    {
        $this->authorize('view', $module);

        return view('modules.show', compact('module'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Module $module)
    {
        $this->authorize('update', $module);

        return view('modules.edit', compact('module'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Module $module)
    {
        $this->authorize('update', $module);

        $data = $request->validate([
            'code' => 'required|string|max:50|unique:modules,code,' . $module->id,
            'name' => 'required|string|max:255',
            'is_archived' => 'nullable|boolean',
        ]);

        $data['is_archived'] = (bool) ($request->has('is_archived') && $request->boolean('is_archived'));

        $module->update($data);

        return redirect()->route('modules.index')->with('success', 'Module updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Module $module)
    {
        if (! auth()->user()->can('delete', $module)) {
            return redirect()->route('modules.index')->with('error', 'You are not authorized to perform that action.');
        }

        $module->delete();

        return redirect()->route('modules.index')->with('success', 'Module deleted.');
    }
}
