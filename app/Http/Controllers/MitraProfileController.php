<?php

namespace App\Http\Controllers;

use App\Models\MitraProfile;
use Illuminate\Http\Request;

class MitraProfileController extends Controller
{
    public function index()
    {
        $mitraProfile = MitraProfile::all();
        return response()->json($mitraProfile);
    }
    
}
