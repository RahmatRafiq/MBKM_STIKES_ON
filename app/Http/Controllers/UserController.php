<?php
namespace App\Http\Controllers;

use App\Helpers\DataTable;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return view('applications.mbkm.admin.role-permission.user.index', compact('users'));
    }

    public function json(Request $request)
    {
        $data = DataTable::paginate(User::class, $request, [
            'id',
            'role_id',
            'name',
            'email',
            'created_at',
            'updated_at',
        ]);

        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        return view('applications.mbkm.admin.role-permission.user.create',compact('roles'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role_id' => 'required|exists:roles,id',
        ]);

        User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
            'role_id' => $validatedData['role_id'],
        ]);

        return redirect()->route('user.index')->with('success', 'User created successfully.');
    }
}
