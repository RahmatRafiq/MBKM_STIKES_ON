<?php

namespace App\Http\Controllers\RolePermission;

use App\Helpers\DataTable;
use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;

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
        //
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
    public function edit(Request $request)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        //
    }
}
