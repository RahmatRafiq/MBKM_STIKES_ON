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
        $search = $request->search['value'];
        $query = User::query();

        // columns
        $columns = [
            'id',
            'name',
            'roles',
            'email',
            'created_at',
            'updated_at',
        ];

        // load roles with search from Datatable ajax
        $query->with('roles', function ($query) use ($search) {
            $query->where('name', 'like', "%{$search}%");
        });

        // search
        if ($request->filled('search')) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
        }

        // order
        if ($request->filled('order')) {
            $query->orderBy($columns[$request->order[0]['column']], $request->order[0]['dir']);
        }

        $data = DataTable::paginate($query, $request);

        return response()->json($data);
    }
    public function create()
    {
        $roles = Role::all();
        return view('applications.mbkm.admin.role-permission.user.create', compact('roles'));
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

    public function show(User $user)
    {
        // return view('applications.mbkm.admin.role-permission.user.show', compact('user'));
    }

    // public function edit(User $user)
    // {
    //     $roles = Role::all();
    //     return view('applications.mbkm.admin.role-permission.user.edit', compact('user', 'roles'));
    // }

    // public function update(Request $request, User $user)
    // {
    //     $validatedData = $request->validate([
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
    //         'password' => 'nullable|string|min:8|confirmed',
    //         'role_id' => 'required|exists:roles,id',
    //     ]);

    //     $user->update([
    //         'name' => $validatedData['name'],
    //         'email' => $validatedData['email'],
    //         'role_id' => $validatedData['role_id'],
    //     ]);

    //     if ($request->filled('password')) {
    //         $user->update([
    //             'password' => bcrypt($validatedData['password']),
    //         ]);
    //     }

    //     return redirect()->route('user.index')->with('success', 'User updated successfully.');
    // }
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        return view('applications.mbkm.admin.role-permission.user.edit', compact('user', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
            'role_id' => 'required|exists:roles,id',
        ]);

        $user = User::findOrFail($id);
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        if ($request->filled('password')) {
            $user->password = bcrypt($validatedData['password']);
        }
        $user->role_id = $validatedData['role_id'];
        $user->save();

        return redirect()->route('user.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('user.index')->with('success', 'User deleted successfully.');
    }
}
