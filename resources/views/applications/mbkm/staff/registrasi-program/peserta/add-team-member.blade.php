@extends('layouts.app')

@section('content')
<h2>Add Team Member</h2>

<!-- Formulir untuk menambahkan anggota tim -->
<form action="{{ route('team.addMember', ['ketua' => $ketua->id]) }}" method="POST">
    @csrf

    <!-- Nama -->
    <div>
        <label for="nama">Name:</label>
        <input type="text" id="nama" name="nama" value="{{ old('nama') }}" required>
        @error('nama')
        <div style="color: red;">{{ $message }}</div>
        @enderror
    </div>

    <!-- Email -->
    <div>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="{{ old('email') }}" required>
        @error('email')
        <div style="color: red;">{{ $message }}</div>
        @enderror
    </div>

    <!-- NIM -->
    <div>
        <label for="nim">NIM:</label>
        <input type="text" id="nim" name="nim" value="{{ old('nim') }}" required>
        @error('nim')
        <div style="color: red;">{{ $message }}</div>
        @enderror
    </div>

    <!-- Password -->
    <div>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        @error('password')
        <div style="color: red;">{{ $message }}</div>
        @enderror
    </div>

    <!-- Konfirmasi Password -->
    <div>
        <label for="password_confirmation">Confirm Password:</label>
        <input type="password" id="password_confirmation" name="password_confirmation" required>
    </div>

    <!-- Alamat -->
    <div>
        <label for="alamat">Address (optional):</label>
        <input type="text" id="alamat" name="alamat" value="{{ old('alamat') }}">
    </div>

    <!-- Jurusan -->
    <div>
        <label for="jurusan">Department (optional):</label>
        <input type="text" id="jurusan" name="jurusan" value="{{ old('jurusan') }}">
    </div>

    <!-- Telepon -->
    <div>
        <label for="telepon">Phone (optional):</label>
        <input type="text" id="telepon" name="telepon" value="{{ old('telepon') }}">
    </div>

    <!-- Jenis Kelamin -->
    <div>
        <label for="jenis_kelamin">Gender (optional):</label>
        <select id="jenis_kelamin" name="jenis_kelamin">
            <option value="">Select Gender</option>
            <option value="Laki-laki" {{ old('jenis_kelamin')=='Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
            <option value="Perempuan" {{ old('jenis_kelamin')=='Perempuan' ? 'selected' : '' }}>Perempuan</option>
        </select>
    </div>
</form>
@endsection