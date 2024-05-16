<?php

namespace App\Http\Controllers;

use App\Helpers\DataTable;
use App\Models\MitraProfile;
use Illuminate\Http\Request;

class MitraProfileController extends Controller
{
    public function index()
    {
        $mitraProfile = MitraProfile::all();

        return view("applications.mbkm.staff.mitra.index", compact("mitraProfile"));
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
    public function create()
    {
        return view('applications.mbkm.staff.mitra.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'type' => 'required',
            'description' => 'required',
            'image' => 'image|nullable|max:2048', // Gambar harus berupa file gambar dengan maksimal ukuran 2MB
        ]);

        // Jika ada file gambar yang diunggah, simpan ke penyimpanan dan dapatkan nama file
        $imagePath = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/images', $imageName); // Simpan gambar di penyimpanan
            $imagePath = 'storage/images/' . $imageName; // Path untuk menyimpan ke database
        }

        // Simpan data mitra beserta nama file gambar ke dalam database
        MitraProfile::create([
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email,
            'website' => $request->website,
            'type' => $request->type,
            'description' => $request->description,
            'image' => $imagePath, // Simpan path gambar ke database
        ]);

        return redirect()->route('mitra.index')->with('success', 'Mitra berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $mitraProfile = MitraProfile::findOrFail($id);
        return view('applications.mbkm.staff.mitra.edit', compact('mitraProfile'));
    }

    public function update(Request $request, $id)
    {
        $mitraProfile = MitraProfile::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'type' => 'required',
            'description' => 'required',
            'image' => 'image|nullable|max:2048',
        ]);

        $imagePath = $mitraProfile->image;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/images', $imageName);
            $imagePath = 'storage/images/' . $imageName;
        }

        $mitraProfile->update([
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email,
            'website' => $request->website,
            'type' => $request->type,
            'description' => $request->description,
            'image' => $imagePath,
        ]);

        return redirect()->route('mitra.index')->with('success', 'Mitra berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $mitraProfile = MitraProfile::findOrFail($id);
        $mitraProfile->delete();
        return redirect()->route('mitra.index')->with('success', 'Mitra berhasil dihapus.');
    }   
}
