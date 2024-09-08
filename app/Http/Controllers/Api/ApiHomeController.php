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

    /**
     * Mengembalikan data overview dan benefits.
     */
    public function getOverviewData()
    {
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

        // Mengembalikan data dalam format JSON
        return response()->json($overview);
    }

    /**
     * Mengembalikan data requirements.
     */
    public function getRequirementsData()
    {
        // Mengambil data pertama dari tabel AboutMbkm
        $aboutMbkm = AboutMbkm::first();

        // Jika data tidak ditemukan, kembalikan respons 404
        if (!$aboutMbkm) {
            return response()->json(['message' => 'About MBKM not found'], 404);
        }

        // Mengambil data requirements
        $requirements = [
            'eligibility' => json_decode($aboutMbkm->eligibility), // Eligibility sebagai array
        ];

        // Mengembalikan data dalam format JSON
        return response()->json($requirements);
    }
}
