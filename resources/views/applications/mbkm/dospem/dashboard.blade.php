@extends('layouts.app')

@section('content')
<!-- App body starts -->
<div class="app-body">
    <div class="row gx-3">
        <div class="col-12 col-lg-6 col-xl-3 mb-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="mb-2">
                        <i class="bi bi-people fs-1 text-primary lh-1"></i>
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="m-0 text-secondary fw-normal">Jumlah Peserta Bimbingan</h5>
                        <h3 class="m-0 text-primary">{{ $jumlahPesertaBimbingan }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-12">
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="card-title">Daftar Peserta Bimbingan</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>NIM</th>
                                    <th>Status Laporan Harian</th>
                                    <th>Status Laporan Mingguan</th>
                                    <th>Status Laporan Lengkap</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pesertaBimbingan as $peserta)
                                <tr>
                                    <td>{{ $peserta->nama }}</td>
                                    <td>{{ $peserta->nim }}</td>
                                    <td>{{ $peserta->laporanHarian->status ?? 'Belum Ada Laporan' }}</td>
                                    <td>{{ $peserta->laporanMingguan->status ?? 'Belum Ada Laporan' }}</td>
                                    <td>{{ $peserta->laporanLengkap->status ?? 'Belum Ada Laporan' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- App body ends -->
@endsection
