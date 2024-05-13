<?php

namespace App\Http\Controllers\RolePermission;

use App\Helpers\DataTable;
use App\Helpers\Guards;
use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('applications.mbkm.admin.role-permission.permission.index');
    }

    public function json(Request $request)
    {
        return response(DataTable::paginate(Permission::class, $request, [
            'id',
            'name',
            'guard_name',
            'created_at',
            'updated_at',
        ]));
    }

    // create reusable function to serve Datatable ajax according json function above

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('applications.mbkm.admin.role-permission.permission.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:permissions',
            'guard_name' => ['required', 'string', 'max:255', Rule::in(Guards::list())],
        ]);

        $permission = new Permission();
        $permission->name = $validatedData['name'];
        $permission->guard_name = $validatedData['guard_name'];
        $permission->save();

        return redirect()->route('permission.index')->with('success', 'Permission created successfully.');
    }


    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id)
    {


        $permission = Permission::findOrFail($id);
        return view('applications.mbkm.admin.role-permission.permission.edit', compact('permission'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:permissions,name,' . $id,
            'guard_name' => 'required|string|max:255',
        ]);

        $permission = Permission::findOrFail($id);
        $permission->name = $validatedData['name'];
        $permission->guard_name = $validatedData['guard_name'];
        $permission->save();

        return redirect()->route('permission.index')->with('success', 'Permission updated successfully.');
    }


    public function destroy($id)
    {
        $permission = Permission::findOrFail($id);
        $permission->delete();

        return redirect()->route('permission.index')->with('success', 'Permission deleted successfully.');
    }
}
