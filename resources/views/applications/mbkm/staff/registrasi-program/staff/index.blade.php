@extends('layouts.app')

@section('content')
<div class="card mb-3">
    <div class="card-body">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title">Manajemen Registrasi</h5>
        </div>
        <div class="table-responsive">
            <table class="table styled-table" id="lowongan">
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
                        <td>
                            <span class="badge 
                                        @if($registration->status == 'registered') badge-registered
                                        @elseif($registration->status == 'processed') badge-processed
                                        @elseif($registration->status == 'accepted') badge-accepted
                                        @elseif($registration->status == 'rejected') badge-rejected
                                        @elseif($registration->status == 'rejected_by_user') badge-rejected_by_user
                                        @elseif($registration->status == 'accepted_offer') badge-accepted_offer
                                        @elseif($registration->status == 'placement') badge-placement
                                        @endif">
                                {{ $registration->status }}
                            </span>
                        </td>
                        <td>
                            @if ($registration->status == 'accepted_offer')
                            <form action="{{ route('staff.updateDospem', $registration->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <select name="dospem_id" class="form-control" required>
                                        <option value="">Pilih Dosen Pembimbing</option>
                                        @foreach ($dospems as $dospem)
                                        <option value="{{ $dospem->id }}" {{ $registration->dospem_id == $dospem->id ?
                                            'selected' : '' }}>
                                            {{ $dospem->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-success mt-2">Update</button>
                            </form>
                            @elseif ($registration->status == 'placement' && $registration->dospem)
                            {{ $registration->dospem->name }}
                            @else
                            <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            {{-- Tombol Lihat Dokumen jika status adalah 'registered' --}}
                            @if ($registration->status == 'registered')
                            <a href="{{ route('registrasi.documents', $registration->id) }}" class="btn btn-info">Lihat
                                Dokumen</a>
                            @endif

                            {{-- Kondisi untuk status lain --}}
                            @if (
                            $registration->status != 'rejected' &&
                            $registration->status != 'placement' &&
                            $registration->status != 'rejected_by_user')
                            @if ($registration->status == 'accepted_offer' && $registration->dospem_id)
                            <form action="{{ route('staff.updateRegistrasi', $registration->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="placement">
                                <button type="submit" class="btn btn-success mt-2">Penempatan</button>
                            </form>
                            @else
                            <form action="{{ route('staff.updateRegistrasi', $registration->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <select name="status" class="form-control">
                                    <option value="registered" @if ($registration->status == 'registered') selected
                                        @endif>
                                        Terdaftar</option>
                                    <option value="processed" @if ($registration->status == 'processed') selected
                                        @endif>Diproses
                                    </option>
                                    <option value="accepted" @if ($registration->status == 'accepted') selected @endif>
                                        Diterima
                                    </option>
                                    <option value="accepted_offer" @if ($registration->status == 'accepted_offer')
                                        selected @endif>
                                        Terima Tawaran</option>
                                    <option value="rejected" @if ($registration->status == 'rejected') selected @endif>
                                        Ditolak
                                    </option>
                                    <option value="rejected_by_user" @if ($registration->status == 'rejected_by_user')
                                        selected @endif>Ditolak oleh
                                        Peserta</option>

                                </select>
                                <button type="submit" class="btn btn-success mt-2">Update</button>
                            </form>
                            @endif
                            @else
                            <span class="text-muted">{{ $registration->status }}</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <a href="#" class="show-all-link">Show All</a>
    </div>
</div>
@endsection

@push('css')
<link rel="stylesheet" href="{{ asset('assets/css/badges.css') }}">
@endpush