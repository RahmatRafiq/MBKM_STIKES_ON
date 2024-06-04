@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Laporan Peserta</h1>

    <h2>Laporan Harian</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Peserta</th>
                <th>Lowongan</th>
                <th>Tanggal</th>
                <th>Isi Laporan</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($laporanHarian as $laporan)
                <tr>
                    <td>{{ $laporan->peserta->nama }}</td>
                    <td>{{ $laporan->lowongan->judul }}</td>
                    <td>{{ $laporan->tanggal }}</td>
                    <td>{{ $laporan->isi_laporan }}</td>
                    <td>{{ $laporan->status }}</td>
                    <td>
                        @if($laporan->status == 'pending' && Auth::user()->id == $laporan->mitra->user_id)
                            <form action="{{ route('laporan.harian.validate', $laporan->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-success">Validasi</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2>Laporan Mingguan</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Peserta</th>
                <th>Lowongan</th>
                <th>Minggu ke-</th>
                <th>Isi Laporan</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($laporanMingguan as $laporan)
                <tr>
                    <td>{{ $laporan->peserta->nama }}</td>
                    <td>{{ $laporan->lowongan->judul }}</td>
                    <td>{{ $laporan->minggu_ke }}</td>
                    <td>{{ $laporan->isi_laporan }}</td>
                    <td>{{ $laporan->status }}</td>
                    <td>
                        @if($laporan->status == 'pending' && Auth::user()->id == $laporan->mitra->user_id)
                            <form action="{{ route('laporan.mingguan.validate', $laporan->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-success">Validasi</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2>Laporan Lengkap</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Peserta</th>
                <th>Lowongan</th>
                <th>Isi Laporan</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($laporanLengkap as $laporan)
                <tr>
                    <td>{{ $laporan->peserta->nama }}</td>
                    <td>{{ $laporan->lowongan->judul }}</td>
                    <td>{{ $laporan->isi_laporan }}</td>
                    <td>{{ $laporan->status }}</td>
                    <td>
                        @if($laporan->status == 'pending' && Auth::user()->id == $laporan->dospem->user_id)
                            <form action="{{ route('laporan.lengkap.validate', $laporan->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-success">Validasi</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
