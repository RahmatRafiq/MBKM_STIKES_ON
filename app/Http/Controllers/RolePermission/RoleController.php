<?php

namespace App\Http\Controllers\RolePermission;

use App\Helpers\DataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

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
}
