<!-- resources/views/peserta/tawaran.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Tawaran Diterima</h2>
    <table class="table">
        <thead>
            <tr>
                <th>ID Registrasi</th>
                <th>Nama Lowongan</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($registrations as $registration)
                @if($registration->status == 'accepted')
                <tr>
                    <td>{{ $registration->id }}</td>
                    <td>{{ $registration->lowongan->name }}</td>
                    <td>{{ $registration->status }}</td>
                    <td>
                        <form action="{{ route('registrasi.acceptOffer', $registration->id) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="dospem_id">Pilih Dosen Pembimbing</label>
                                <select name="dospem_id" class="form-control">
                                    @foreach($dospems as $dospem)
                                        <option value="{{ $dospem->id }}">{{ $dospem->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-success">Ambil Tawaran</button>
                        </form>
                    </td>
                </tr>
                @endif
            @endforeach
        </tbody>
    </table>
</div>
@endsection
// resources/views/applications/mbkm/staff/registrasi-program/peserta_accept_offer.blade.php

{{-- @extends('layouts.app')

@section('content')
    <h1>Terima Tawaran</h1>
    <form action="{{ route('registrasi.update', $registration->id) }}" method="POST">
        @csrf
        @method('PUT')
        <label for="status">Status:</label>
        <select name="status" required>
            <option value="processed">Proses</option>
            <option value="accepted">Diterima</option>
            <option value="rejected">Ditolak</option>
        </select>
        <label for="dospem_id">Pilih Dosen Pembimbing Lapangan:</label>
        <select name="dospem_id">
            @foreach($dospems as $dospem)
                <option value="{{ $dospem->id }}">{{ $dospem->nama }}</option>
            @endforeach
        </select>
        <button type="submit">Submit</button>
    </form>
@endsection --}}
