<?php

namespace App\Http\Controllers\RolePermission;

use App\Helpers\DataTable;
use App\Helpers\Guards;
use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;


class RoleController extends Controller
{
    public function index()
    {
        return view('applications.mbkm.admin.role-permission.role.index');
    }

    public function json(Request $request)
    {
        return response(DataTable::paginate(Role::class, $request, [
            'id',
            'role',
            'guard_name',
            'created_at',
            'updated_at',
        ]));
    }

    public function create()
    {
        return view('applications.mbkm.admin.role-permission.role.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:roles',
            'guard_name' => ['required', 'string', 'max:255', Rule::in(Guards::list())],
        ]);

        $role = new Role();
        $role->name = $validatedData['name'];
        $role->guard_name = $validatedData['guard_name'];
        $role->save();
        return redirect()->route('role.index')->with('success', 'Role created successfully.');
    }

    public function show(Role $role)
    {
        //
    }
    public function edit(Role $role)
    {
        $role = Role::findOrFail($role);
        return view('applications.mbkm.admin.role-permission.role.edit', compact('role'));
    }

    public function update(Request $request, Role $role)
    {
        $validatedData = $request->validate([
            'role' => 'required|string|max:255|unique:roles,role,' . $role->id,
            'guard_name' => ['required', 'string', 'max:255', Rule::in(Guards::list())],
        ]);

        $role->name = $validatedData['role'];
        $role->guard_name = $validatedData['guard_name'];
        $role->save();

        return redirect()->route('role.index')->with('success', 'Role updated successfully.');
    }

    public function destroy(Role $role)
    {
        $role->delete();
        return response()->json(['message' => 'Role deleted successfully.']);
    }

    public function addPermissionToRole(Role $roleId)
    {
        $permissions = Permission::get();
        $roleId = Role::findOrFail($roleId);
        return view('applications.mbkm.admin.role-permission.role.add-permission', compact('roleId', 'permissions'));
    }

}
