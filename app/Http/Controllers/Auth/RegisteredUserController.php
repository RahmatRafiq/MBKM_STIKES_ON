<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\sisfo\Mahasiswa;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Validasi input
        $request->validate([
            'nim' => ['required'], // NIM harus tepat 6 digit
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'termsConditions' => ['required', 'accepted'],
        ]);

        // Cek apakah NIM memenuhi kriteria MBKM
        $mahasiswa = Mahasiswa::getEligibleMahasiswa()->firstWhere('MhswID', $request->nim);

        if (!$mahasiswa) {
            // Jika NIM tidak memenuhi kriteria, kembalikan dengan pesan error
            return back()->withErrors(['nim' => 'Maaf, Anda tidak memenuhi kriteria MBKM.']);
        }

        // Jika validasi berhasil, buat user baru
        $user = User::create([
            'name' => $mahasiswa->Nama, // Menggunakan nama dari data mahasiswa
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Assign role jika ada (optional)
        $user->assignRole('user');

        // Trigger event Registered
        event(new Registered($user));

        // Login otomatis setelah registrasi
        Auth::login($user);

        // Redirect ke dashboard
        return redirect(route('dashboard'));
    }
}
