@extends('layouts.app')

@section('content')
<div class="card mb-3">
    <div class="card-body">
        <h2 class="mb-4">Tambah Anggota Tim</h2>

        <!-- Formulir untuk menambahkan anggota tim -->
        <form action="{{ route('team.addMember', ['ketua' => $ketua->id]) }}" method="POST">
            @csrf
            <div class="row">
                <!-- Kolom Kiri -->
                <div class="col-md-6">
                    <!-- Nama -->
                    <div class="form-group mb-3">
                        <label for="nama">Nama:</label>
                        <input type="text" id="nama" name="nama" class="form-control" value="{{ old('nama') }}" required>
                        @error('nama')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="form-group mb-3">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" required>
                        @error('email')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- NIM -->
                    <div class="form-group mb-3">
                        <label for="nim">NIM:</label>
                        <input type="text" id="nim" name="nim" class="form-control" value="{{ old('nim') }}" required>
                        @error('nim')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="form-group mb-3">
                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password" class="form-control" required>
                        @error('password')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Konfirmasi Password -->
                    <div class="form-group mb-3">
                        <label for="password_confirmation">Konfirmasi Password:</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
                    </div>
                </div>

                <!-- Kolom Kanan -->
                <div class="col-md-6">
                    <!-- Alamat -->
                    <div class="form-group mb-3">
                        <label for="alamat">Alamat (Opsional):</label>
                        <input type="text" id="alamat" name="alamat" class="form-control" value="{{ old('alamat') }}">
                    </div>

                    <!-- Jurusan -->
                    <div class="form-group mb-3">
                        <label for="jurusan">Jurusan (Opsional):</label>
                        <input type="text" id="jurusan" name="jurusan" class="form-control" value="{{ old('jurusan') }}">
                    </div>

                    <!-- Telepon -->
                    <div class="form-group mb-3">
                        <label for="telepon">Telepon (Opsional):</label>
                        <input type="text" id="telepon" name="telepon" class="form-control" value="{{ old('telepon') }}">
                    </div>

                    <!-- Jenis Kelamin -->
                    <div class="form-group mb-3">
                        <label for="jenis_kelamin">Jenis Kelamin (Opsional):</label>
                        <select id="jenis_kelamin" name="jenis_kelamin" class="form-control">
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Tambah Anggota</button>
        </form>
    </div>
</div>

<div class="card mb-3">
    <div class="card-body">
        <h3 class="mt-3">Daftar Anggota Tim</h3>
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($anggotaTim as $anggota)
                <tr>
                    <td>{{ $anggota->peserta->nama }}</td>
                    <td>{{ $anggota->peserta->email }}</td>
                    <td>
                        <form action="{{ route('team.removeMember', ['id' => $anggota->id]) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus anggota ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
