<?php

namespace App\Http\Controllers\Landing;

use App\Http\Controllers\Controller;
use App\Models\AboutMbkm;
use App\Models\TypeProgram;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    function home()
    {
        $programs = TypeProgram::all(['id', 'name', 'description']);
        // Mengambil data pertama dari tabel AboutMbkm
        $aboutMbkm = AboutMbkm::first();

        // Jika data tidak ditemukan, kembalikan respons 404
        if (!$aboutMbkm) {
            return response()->json(['message' => 'About MBKM not found'], 404);
        }

        // Mengambil data overview dan benefits
        $overview = [
            'name' => $aboutMbkm->program_name, // Nama program
            'description' => $aboutMbkm->description, // Deskripsi program
            'benefits' => json_decode($aboutMbkm->benefits), // Benefits sebagai array
        ];
        return inertia('Home', [
            'programs' => $programs,
            'overview' => $overview
        ]);
    }
}
