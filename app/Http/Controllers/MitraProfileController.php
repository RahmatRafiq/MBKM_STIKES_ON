<?php

namespace App\Http\Controllers;

use App\Helpers\DataTable;
use App\Helpers\MediaLibrary;
use App\Models\MitraProfile;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MitraProfileController extends Controller
{
    public function index()
    {
        $mitraProfile = MitraProfile::all();
        return view('applications.mbkm.staff.mitra.index', compact('mitraProfile'));
    }

    public function json(Request $request)
    {
        $search = $request->search['value'];
        $query = MitraProfile::query();

        // columns
        $columns = [
            'id',
            'name',
            'address',
            'phone',
            'email',
            'website',
            'type',
            'description',
            'images',
            'created_at',
            'updated_at',
        ];

        // search
        if ($request->filled('search')) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('address', 'like', "%{$search}%")
                ->orWhere('phone', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhere('website', 'like', "%{$search}%")
                ->orWhere('type', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%");
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
        return view('applications.mbkm.staff.mitra.create', compact('roles'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'mitra_name' => 'required|string|max:255',
            'mitra_address' => 'required|string|max:255',
            'mitra_phone' => 'required|string|max:15',
            'mitra_email' => 'required|email|max:255',
            'mitra_website' => 'nullable|url|max:255',
            'mitra_type' => 'required|string|max:255',
            'mitra_description' => 'required|string',
            'mitra_images' => 'array|max:3',
            'user_name' => 'required|string|max:255',
            'user_email' => 'required|string|email|max:255|unique:users,email',
            'user_password' => 'required|string|min:8|confirmed',
            // 'role_id' => 'required|exists:roles,id'
        ]);

        $images = [];
        if ($request->hasFile('mitra_images')) {
            foreach ($request->file('mitra_images') as $image) {
                $path = $image->store('images', 'public');
                $images[] = $path;
            }
        }

        $mitraProfile = MitraProfile::create([
            'name' => $request->mitra_name,
            'address' => $request->mitra_address,
            'phone' => $request->mitra_phone,
            'email' => $request->mitra_email,
            'website' => $request->mitra_website,
            'type' => $request->mitra_type,
            'description' => $request->mitra_description,
            'images' => json_encode($images),

        ]);
        $mitraRole = Role::where('name', 'Mitra')->firstOrFail();

        User::create([
            'name' => $request->user_name,
            'email' => $request->user_email,
            'password' => bcrypt($request->user_password),
            // 'role_id' => $mitraRole->id,
        ]);

        return redirect()->route('mitra.index')->with('success', 'Mitra and User created successfully.');
    }


    public function edit($id)
    {
        $item = MitraProfile::findOrFail($id);
        return view('applications.mbkm.staff.mitra.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'email' => 'required|email|max:255',
            'website' => 'nullable|url|max:255',
            'type' => 'required|string|max:255',
            'description' => 'required|string',
            'images' => 'array|max:3',
        ]);

        $mitraProfile = MitraProfile::findOrFail($id);

        $media = MediaLibrary::put(
            $mitraProfile,
            'images',
            $request
        );

        $mitraProfile->update([
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email,
            'website' => $request->website,
            'type' => $request->type,
            'description' => $request->description,
        ]);

        return redirect()->route('mitra.index')->with([
            'success' => 'Mitra updated successfully.',
            'media' => $media,
        ]);
    }

    public function destroy($id)
    {
        $mitraProfile = MitraProfile::findOrFail($id);

        $mitraProfile->delete();

        return redirect()->route('mitra.index')->with('success', 'Mitra deleted successfully.');
    }
}
