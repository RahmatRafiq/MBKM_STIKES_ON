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

