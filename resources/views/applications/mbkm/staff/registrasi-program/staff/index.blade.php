{{-- @extends('layouts.app')

@section('content')
    <div class="card mb-3">
        <div class="card-body">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title">Manajemen Registrasi</h5>
                <div class="mb-3">
                </div>
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
                                <td>{{ $registration->status }}</td>
                                <td>
                                    @if ($registration->status == 'accepted_offer')
                                        <form action="{{ route('staff.updateDospem', $registration->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="form-group">
                                                <select name="dospem_id" class="form-control" required>
                                                    <option value="">Pilih Dosen Pembimbing</option>
                                                    @foreach ($dospems as $dospem)
                                                        <option value="{{ $dospem->id }}"
                                                            {{ $registration->dospem_id == $dospem->id ? 'selected' : '' }}>
                                                            {{ $dospem->name }}</option>
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
                                    @if ($registration->status != 'rejected' && $registration->status != 'accepted_offer')
                                        <form action="{{ route('staff.updateRegistrasi', $registration->id) }}"
                                            method="POST">
                                            @csrf
                                            @method('PUT')
                                            <select name="status" class="form-control">
                                                <option value="registered"
                                                    @if ($registration->status == 'registered') selected @endif>
                                                    Terdaftar</option>
                                                <option value="processed"
                                                    @if ($registration->status == 'processed') selected @endif>Diproses
                                                </option>
                                                <option value="accepted" @if ($registration->status == 'accepted') selected @endif>
                                                    Diterima
                                                </option>
                                                <option value="accepted_offer"
                                                    @if ($registration->status == 'accepted_offer') selected @endif>
                                                    Terima Tawaran</option>
                                                <option value="rejected" @if ($registration->status == 'rejected') selected @endif>
                                                    Ditolak
                                                </option>
                                            </select>
                                            <button type="submit" class="btn btn-success mt-2">Update</button>
                                        </form>
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
@endsection --}}
{{-- @extends('layouts.app')

@section('content')
    <div class="card mb-3">
        <div class="card-body">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title">Manajemen Registrasi</h5>
                <div class="mb-3">
             
                </div>
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
                                <td>{{ $registration->status }}</td>
                                <td>
                                    @if ($registration->status == 'accepted_offer')
                                        <form action="{{ route('staff.updateDospem', $registration->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="form-group">
                                                <select name="dospem_id" class="form-control" required>
                                                    <option value="">Pilih Dosen Pembimbing</option>
                                                    @foreach ($dospems as $dospem)
                                                        <option value="{{ $dospem->id }}"
                                                            {{ $registration->dospem_id == $dospem->id ? 'selected' : '' }}>
                                                            {{ $dospem->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <button type="submit" class="btn btn-success mt-2">Update</button>
                                        </form>
                                    @elseif ($registration->status == 'placement')
                                        <span class="text-muted">Penempatan</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($registration->status != 'rejected' && $registration->status != 'placement')
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
                                                    <option value="registered"
                                                        @if ($registration->status == 'registered') selected @endif>
                                                        Terdaftar</option>
                                                    <option value="processed"
                                                        @if ($registration->status == 'processed') selected @endif>Diproses
                                                    </option>
                                                    <option value="accepted" @if ($registration->status == 'accepted') selected @endif>
                                                        Diterima
                                                    </option>
                                                    <option value="accepted_offer"
                                                        @if ($registration->status == 'accepted_offer') selected @endif>
                                                        Terima Tawaran</option>
                                                    <option value="rejected" @if ($registration->status == 'rejected') selected @endif>
                                                        Ditolak
                                                    </option>
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
@endsection --}}

@extends('layouts.app')

@section('content')
    <div class="card mb-3">
        <div class="card-body">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title">Manajemen Registrasi</h5>
                <div class="mb-3">
                    {{-- <a href="#" class="btn btn-success">Tambah Data Lowongan</a> --}}
                </div>
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
                                <td>{{ $registration->status }}</td>
                                <td>
                                    @if ($registration->status == 'accepted_offer')
                                        <form action="{{ route('staff.updateDospem', $registration->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="form-group">
                                                <select name="dospem_id" class="form-control" required>
                                                    <option value="">Pilih Dosen Pembimbing</option>
                                                    @foreach ($dospems as $dospem)
                                                        <option value="{{ $dospem->id }}"
                                                            {{ $registration->dospem_id == $dospem->id ? 'selected' : '' }}>
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
                                    @if ($registration->status != 'rejected' && $registration->status != 'placement')
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
                                                    <option value="registered"
                                                        @if ($registration->status == 'registered') selected @endif>
                                                        Terdaftar</option>
                                                    <option value="processed"
                                                        @if ($registration->status == 'processed') selected @endif>Diproses
                                                    </option>
                                                    <option value="accepted" @if ($registration->status == 'accepted') selected @endif>
                                                        Diterima
                                                    </option>
                                                    <option value="accepted_offer"
                                                        @if ($registration->status == 'accepted_offer') selected @endif>
                                                        Terima Tawaran</option>
                                                    <option value="rejected" @if ($registration->status == 'rejected') selected @endif>
                                                        Ditolak
                                                    </option>
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