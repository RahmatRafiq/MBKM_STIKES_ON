<?php

namespace App\Http\Controllers;

use App\Helpers\DataTable;
use App\Helpers\MediaLibrary;
use App\Models\MitraProfile;
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
        return view('applications.mbkm.staff.mitra.create');
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
            'images' => 'array|max:3',
        ]);

        $item = MitraProfile::create([
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email,
            'website' => $request->website,
            'type' => $request->type,
            'description' => $request->description,
        ]);

        $media = MediaLibrary::put(
            $item,
            'images',
            $request
        );

        return redirect()->route('mitra.index')->with([
            'success' => 'Mitra created successfully.',
            'media' => $media,
        ]);
    }

    // Edit method
    public function edit($id)
    {
        $item = MitraProfile::findOrFail($id);
        return view('applications.mbkm.staff.mitra.edit', compact('item'));
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

    // Destroy method
    public function destroy($id)
    {
        $mitraProfile = MitraProfile::findOrFail($id);

        $mitraProfile->delete();

        return redirect()->route('mitra.index')->with('success', 'Mitra deleted successfully.');
    }
}
