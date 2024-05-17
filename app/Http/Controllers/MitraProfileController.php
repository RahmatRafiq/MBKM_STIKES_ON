<?php

namespace App\Http\Controllers;

use App\Helpers\DataTable;
use App\Models\MitraProfile;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MitraProfileController extends Controller
{
    // Index method
    public function index()
    {
        $mitraProfile = MitraProfile::all();
        return view('applications.mbkm.staff.mitra.index', compact('mitraProfile'));
    }

    public function json(Request $request)
    {
        return response(DataTable::paginate(MitraProfile::class, $request, [
            'id',
            'name',
            'address',
            'phone',
            'email',
            'website',
            'image',
            'type',
            'description',
        ]));
    }

    // Create method
    public function create()
    {
        $roles = Role::all();
        return view('applications.mbkm.staff.mitra.create', compact('roles'));
    }

    // Store method
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'email' => 'required|email|max:255',
            'website' => 'nullable|url|max:255',
            'type' => 'required|string|max:255',
            'description' => 'required|string',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $images = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('images', 'public');
                $images[] = $path;
            }
        }

        MitraProfile::create([
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email,
            'website' => $request->website,
            'type' => $request->type,
            'description' => $request->description,
            'images' => json_encode($images),
        ]);

        return redirect()->route('mitra.index')->with('success', 'Mitra created successfully.');
    }

    public function storeMitraUser(Request $request)
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

        return redirect()->route('mitra.index')->with('success', 'User created successfully.');
    }

    // Edit method
    public function edit($id)
    {
        $mitraProfile = MitraProfile::findOrFail($id);
        return view('applications.mbkm.staff.mitra.edit', compact('mitraProfile'));
    }

    // Update method
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
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $mitraProfile = MitraProfile::findOrFail($id);

        $images = json_decode($mitraProfile->images, true) ?? [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('images', 'public');
                $images[] = $path;
            }
        }

        $mitraProfile->update([
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email,
            'website' => $request->website,
            'type' => $request->type,
            'description' => $request->description,
            'images' => json_encode($images),
        ]);

        return redirect()->route('mitra.index')->with('success', 'Mitra updated successfully.');
    }

    // Destroy method
    public function destroy($id)
    {
        $mitraProfile = MitraProfile::findOrFail($id);
        if ($mitraProfile->images) {
            foreach (json_decode($mitraProfile->images) as $image) {
                Storage::disk('public')->delete($image);
            }
        }
        $mitraProfile->delete();

        return redirect()->route('mitra.index')->with('success', 'Mitra deleted successfully.');
    }
}
