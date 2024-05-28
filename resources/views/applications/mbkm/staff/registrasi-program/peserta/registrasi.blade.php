<!-- resources/views/applications/mbkm/staff/registrasi-program/peserta/registrasi.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Registrasi Peserta</h2>
    <form action="{{ route('peserta.registrasi') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="peserta_id">ID Peserta</label>
            <input type="text" class="form-control" id="peserta_id" name="peserta_id" value="{{ auth()->user()->id }}" readonly>
        </div>
        <div class="form-group">
            <label for="lowongan_id">Pilih Lowongan</label>
            <select class="form-control" id="lowongan_id" name="lowongan_id">
                @foreach($lowongans as $lowongan)
                    <option value="{{ $lowongan->id }}">{{ $lowongan->name }} - {{ $lowongan->mitra->type }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Daftar</button>
    </form>
</div>
@endsection
