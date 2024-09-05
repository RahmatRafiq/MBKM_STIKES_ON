<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\AboutMbkm;
use App\Models\TypeProgram;
use Illuminate\Http\Request;

class ApiHomeController extends Controller
{
    /**
     * Mengembalikan daftar program.
     */
    public function getPrograms()
    {
        // Mengambil semua data program dari database
        $programs = TypeProgram::all(['id', 'name', 'description']);

        // Mengembalikan data dalam format JSON
        return response()->json($programs);
    }

    public function getOverviewData()
    {
        // Mengambil data pertama dari tabel AboutMbkm
        $aboutMbkm = AboutMbkm::first();

        // Jika data tidak ditemukan, kembalikan response 404
        if (!$aboutMbkm) {
            return response()->json(['message' => 'About MBKM not found'], 404);
        }

        // Mengambil data overview: program_name dan description
        $overview = [
            'name' => $aboutMbkm->program_name, // Nama program
            'description' => $aboutMbkm->description // Deskripsi program
        ];

        // Mengembalikan data dalam format JSON
        return response()->json($overview);
    }
}
