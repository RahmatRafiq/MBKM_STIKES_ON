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
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
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

        // // store images from temp
        // foreach ($request->images as $key => $value) {
        //     $item->addMediaFromDisk($value, 'temp')->toMediaCollection('images');
        // }

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
            // images is array of string
            'images.*' => 'nullable|string',
        ]);
        // dd($request);

        $mitraProfile = MitraProfile::findOrFail($id);

        // // retrieve saved images
        // $images = $mitraProfile->getMedia('images');

        // // get image that will be removed if exists in $images and not exists in $request
        // $filesToRemove = $images->filter(function ($image) use ($request) {
        //     return !in_array($image->file_name, $request->images);
        // });

        // // remove images from media
        // foreach ($filesToRemove as $image) {
        //     $image->delete();
        // }

        // // add images from temp
        // foreach ($request->images as $key => $value) {
        //     if (!$images->contains('file_name', $value)) {
        //         $mitraProfile->addMediaFromDisk($value, 'temp')->toMediaCollection('images');
        //     }
        // }

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
