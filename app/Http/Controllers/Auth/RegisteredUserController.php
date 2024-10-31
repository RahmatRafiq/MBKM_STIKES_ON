<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Peserta;
use App\Models\sisfo\Mahasiswa;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
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
            'nim' => ['required'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'termsConditions' => ['required', 'accepted'],
            'new_email' => [
                'nullable',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($request->use_siakad_email ? $request->new_email : null),
            ],
        ]);

        // Cek apakah NIM memenuhi kriteria MBKM
        $mahasiswa = Mahasiswa::getEligibleMahasiswa()->firstWhere('MhswID', $request->nim);

        if (!$mahasiswa) {
            return back()->withErrors(['nim' => 'Maaf, Anda tidak memenuhi kriteria MBKM.']);
        }

        // Tentukan email yang akan digunakan
        $email = $request->has('use_siakad_email') ? $mahasiswa->Email : $request->new_email;

        // Buat user baru
        $user = User::create([
            'name' => $mahasiswa->Nama, // Nama diambil dari data mahasiswa
            'email' => $email,
            'password' => Hash::make($request->password),
        ]);

        // Assign role 'peserta'
        $user->assignRole('peserta');

        // Trigger event Registered
        event(new Registered($user));

        // Login otomatis setelah registrasi
        Auth::login($user);

        // Buat data Peserta juga
        Peserta::create([
            'user_id' => $user->id,
            'nim' => $mahasiswa->MhswID,
            'nama' => $mahasiswa->Nama,
            'email' => $email,
            'alamat' => $mahasiswa->Alamat,
            'jurusan' => $mahasiswa->KDPIN,
            'telepon' => $mahasiswa->telepon,
            'jenis_kelamin' => $mahasiswa->Kelamin,
        ]);

        // Redirect ke dashboard
        return redirect(route('dashboard'))->with('success', 'Pendaftaran berhasil.');
    }

}
