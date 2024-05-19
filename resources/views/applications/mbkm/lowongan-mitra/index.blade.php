@extends('layouts.app')

@section('content')
    <div class="card mb-3">
        <div class="card-body">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title">Lowongan Data</h5>
                <div class="mb-3">
                    <a href="{{ route('lowongan.create') }}" class="btn btn-success">Tambah Data Lowongan</a>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table styled-table" id="lowongan">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Mitra</th>
                            <th>Deskripsi</th>
                            <th>Quota</th>
                            <th>Status</th>
                            <th>Lokasi</th>
                            <th>IPK</th>
                            <th>Semester</th>
                            <th>Pengalaman</th>
                            <th>Tanggal Mulai</th>
                            <th>Tanggal Berakhir</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($lowongans as $lowongan)
                            <tr>
                                <td>{{ $lowongan->name }}</td>
                                <td>{{ $lowongan->mitra->name }}</td>
                                <td>{{ $lowongan->description }}</td>
                                <td>{{ $lowongan->quota }}</td>
                                <td>{{ $lowongan->is_open ? 'Open' : 'Closed' }}</td>
                                <td>{{ $lowongan->location }}</td>
                                <td>{{ $lowongan->gpa }}</td>
                                <td>{{ $lowongan->semester }}</td>
                                <td>{{ $lowongan->experience_required }}</td>
                                <td>{{ $lowongan->start_date }}</td>
                                <td>{{ $lowongan->end_date }}</td>
                                <td>
                                    <a href="{{ route('lowongan.edit', $lowongan->id) }}" class="btn btn-primary">Ubah</a>
                                    <form action="{{ route('lowongan.destroy', $lowongan->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')">Hapus</button>
                                    </form>
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
