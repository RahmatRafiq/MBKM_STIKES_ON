@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Daftar Laporan</h2>

    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="harian-tab" data-bs-toggle="tab" data-bs-target="#harian" type="button" role="tab" aria-controls="harian" aria-selected="true">Laporan Harian</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="mingguan-tab" data-bs-toggle="tab" data-bs-target="#mingguan" type="button" role="tab" aria-controls="mingguan" aria-selected="false">Laporan Mingguan</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="lengkap-tab" data-bs-toggle="tab" data-bs-target="#lengkap" type="button" role="tab" aria-controls="lengkap" aria-selected="false">Laporan Lengkap</button>
        </li>
    </ul>

    <div class="tab-content" id="myTabContent">
        <!-- Laporan Harian -->
        <div class="tab-pane fade show active" id="harian" role="tabpanel" aria-labelledby="harian-tab">
            <table class="table mt-3">
                <thead>
                    <tr>
                        <th>Nama Peserta</th>
                        <th>Mitra</th>
                        <th>Tanggal</th>
                        <th>Isi Laporan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($laporanHarian as $laporan)
                    <tr>
                        {{-- <td>{{ $laporan->peserta->nama }}</td> --}}
                        <td>{{ $laporan->mitra->name }}</td>
                        <td>{{ $laporan->tanggal }}</td>
                        <td>{{ $laporan->isi_laporan }}</td>
                        <td>{{ $laporan->status }}</td>
                        <td>
                            @if($laporan->status == 'pending')
                            <form action="{{ route('laporan.harian.validate', $laporan->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success">Validasi</button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Laporan Mingguan -->
        <div class="tab-pane fade" id="mingguan" role="tabpanel" aria-labelledby="mingguan-tab">
            <table class="table mt-3">
                <thead>
                    <tr>
                        <th>Nama Peserta</th>
                        <th>Mitra</th>
                        <th>Minggu Ke</th>
                        <th>Isi Laporan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($laporanMingguan as $laporan)
                    <tr>
                        <td>{{ $laporan->peserta->nama }}</td>
                        <td>{{ $laporan->mitra->name }}</td>
                        <td>{{ $laporan->minggu_ke }}</td>
                        <td>{{ $laporan->isi_laporan }}</td>
                        <td>{{ $laporan->status }}</td>
                        <td>
                            @if($laporan->status == 'pending')
                            <form action="{{ route('laporan.mingguan.validate', $laporan->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success">Validasi</button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Laporan Lengkap -->
        <div class="tab-pane fade" id="lengkap" role="tabpanel" aria-labelledby="lengkap-tab">
            <table class="table mt-3">
                <thead>
                    <tr>
                        <th>Nama Peserta</th>
                        <th>Dosen Pembimbing</th>
                        <th>Isi Laporan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($laporanLengkap as $laporan)
                    <tr>
                        {{-- <td>{{ $laporan->peserta->nama }}</td> --}}
                        <td>{{ $laporan->dospem->name }}</td>
                        <td>{{ $laporan->isi_laporan }}</td>
                        <td>{{ $laporan->status }}</td>
                        <td>
                            @if($laporan->status == 'pending')
                            <form action="{{ route('laporan.lengkap.validate', $laporan->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success">Validasi</button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
{{-- 

@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Daftar Laporan</h2>

    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="harian-tab" data-bs-toggle="tab" data-bs-target="#harian" type="button" role="tab" aria-controls="harian" aria-selected="true">Laporan Harian</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="mingguan-tab" data-bs-toggle="tab" data-bs-target="#mingguan" type="button" role="tab" aria-controls="mingguan" aria-selected="false">Laporan Mingguan</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="lengkap-tab" data-bs-toggle="tab" data-bs-target="#lengkap" type="button" role="tab" aria-controls="lengkap" aria-selected="false">Laporan Lengkap</button>
        </li>
    </ul>

    <div class="tab-content" id="myTabContent">
        <!-- Laporan Harian -->
        <div class="tab-pane fade show active" id="harian" role="tabpanel" aria-labelledby="harian-tab">
            <table class="table mt-3">
                <thead>
                    <tr>
                        <th>Nama Peserta</th>
                        <th>Mitra</th>
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
                        <td>{{ $laporan->mitra->name }}</td>
                        <td>{{ $laporan->tanggal }}</td>
                        <td>{{ $laporan->isi_laporan }}</td>
                        <td>{{ $laporan->status }}</td>
                        <td>
                            @if($laporan->status == 'pending')
                            <form action="{{ route('laporan.harian.validate', $laporan->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success">Validasi</button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Laporan Mingguan -->
        <div class="tab-pane fade" id="mingguan" role="tabpanel" aria-labelledby="mingguan-tab">
            <table class="table mt-3">
                <thead>
                    <tr>
                        <th>Nama Peserta</th>
                        <th>Mitra</th>
                        <th>Minggu Ke</th>
                        <th>Isi Laporan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($laporanMingguan as $laporan)
                    <tr>
                        <td>{{ $laporan->peserta->nama }}</td>
                        <td>{{ $laporan->mitra->name }}</td>
                        <td>{{ $laporan->minggu_ke }}</td>
                        <td>{{ $laporan->isi_laporan }}</td>
                        <td>{{ $laporan->status }}</td>
                        <td>
                            @if($laporan->status == 'pending')
                            <form action="{{ route('laporan.mingguan.validate', $laporan->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success">Validasi</button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Laporan Lengkap -->
        <div class="tab-pane fade" id="lengkap" role="tabpanel" aria-labelledby="lengkap-tab">
            <table class="table mt-3">
                <thead>
                    <tr>
                        <th>Nama Peserta</th>
                        <th>Dosen Pembimbing</th>
                        <th>Isi Laporan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($laporanLengkap as $laporan)
                    <tr>
                        <td>{{ $laporan->peserta->nama }}</td>
                        <td>{{ $laporan->dospem->name }}</td>
                        <td>{{ $laporan->isi_laporan }}</td>
                        <td>{{ $laporan->status }}</td>
                        <td>
                            @if($laporan->status == 'pending')
                            <form action="{{ route('laporan.lengkap.validate', $laporan->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success">Validasi</button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection --}}
