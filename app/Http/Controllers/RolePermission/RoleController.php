<?php

namespace App\Http\Controllers\RolePermission;

use App\Helpers\DataTable;
use App\Helpers\Guards;
use App\Http\Controllers\Controller;
use App\Models\Role;
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
            'name',
            'guard_name',
            'created_at',
            'updated_at',
        ]));
    }

    public function create()
    {
        return view('applications.mbkm.admin.role-permission.permission.create');
    }

    public function store(Request $request)
    {
         $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:permissions',
            'guard_name' => ['required', 'string', 'max:255', Rule::in(Guards::list())],
        ]);

        $permission = new Role();
        $permission->name = $validatedData['name'];
        $permission->guard_name = $validatedData['guard_name'];
        $permission->save();

        return redirect()->route('permission.index')->with('success', 'Permission created successfully.');}

    public function destroy(Role $role)
    {
        $role->delete();
        return response()->json(['message' => 'Role deleted successfully.']);
    }
}
