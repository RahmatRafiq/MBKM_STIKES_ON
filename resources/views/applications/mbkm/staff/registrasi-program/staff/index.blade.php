@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Manajemen Registrasi</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>ID Registrasi</th>
                    <th>Nama Peserta</th>
                    <th>Lowongan</th>
                    <th>Status</th>
                    <th>Dosen Pembimbing</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($registrations as $registration)
                    <tr>
                        <td>{{ $registration->id }}</td>
                        <td>{{ $registration->nama_peserta }}</td>
                        <td>{{ $registration->nama_lowongan }}</td>
                        <td>{{ $registration->status }}</td>
                        <td>
                            @if($registration->status == 'accepted_offer')
                                <form action="{{ route('staff.updateDospem', $registration->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="form-group">
                                        <select name="dospem_id" class="form-control" required>
                                            <option value="">Pilih Dosen Pembimbing</option>
                                            @foreach($dospems as $dospem)
                                                <option value="{{ $dospem->id }}" {{ $registration->dospem_id == $dospem->id ? 'selected' : '' }}>{{ $dospem->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-success mt-2">Update</button>
                                </form>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            <form action="{{ route('staff.updateRegistrasi', $registration->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <select name="status" class="form-control">
                                    <option value="registered" @if ($registration->status == 'registered') selected @endif>Terdaftar</option>
                                    <option value="processed" @if ($registration->status == 'processed') selected @endif>Diproses</option>
                                    <option value="accepted" @if ($registration->status == 'accepted') selected @endif>Diterima</option>
                                    <option value="accepted_offer" @if ($registration->status == 'accepted_offer') selected @endif>Terima Tawaran</option>
                                    <option value="rejected" @if ($registration->status == 'rejected') selected @endif>Ditolak</option>
                                </select>
                                <button type="submit" class="btn btn-success mt-2">Update</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection


