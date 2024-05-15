<?php
namespace App\Http\Controllers;

use App\Helpers\DataTable;
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
        return view('applications.mbkm.admin.role-permission.user.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
        ]);

        User::create($request->all());

        return redirect()->route('user.index')
            ->with('success', 'User created successfully.');
    }

}
