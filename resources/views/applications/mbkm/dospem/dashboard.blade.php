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
        <div class="col-12 col-lg-6 col-xl-3 mb-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="mb-2">
                        <i class="bi bi-file-earmark-text fs-1 text-primary lh-1"></i>
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="m-0 text-secondary fw-normal">Laporan Harian</h5>
                        <h3 class="m-0 text-primary">{{ $laporanHarian }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6 col-xl-3 mb-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="mb-2">
                        <i class="bi bi-calendar-week fs-1 text-primary lh-1"></i>
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="m-0 text-secondary fw-normal">Laporan Mingguan</h5>
                        <h3 class="m-0 text-primary">{{ $laporanMingguan }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-6 col-xl-3 mb-3">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="mb-2">
                        <i class="bi bi-file-earmark-text fs-1 text-primary lh-1"></i>
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="m-0 text-secondary fw-normal">Laporan Lengkap</h5>
                        <h3 class="m-0 text-primary">{{ $laporanLengkap }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="card-title">Laporan Harian Berdasarkan Status</h5>
                </div>
                <div class="card-body">
                    <div id="donutChartHarian"></div>
                </div>
                <div class="grid text-center">
                    <div class="g-col-4">
                        <i class="bi bi-check-circle-fill text-success"></i>
                        <h3 class="m-0 mt-1">{{ $validasiHarian }}</h3>
                        <p class="text-secondary m-0">Tervalidasi</p>
                    </div>
                    <div class="g-col-4">
                        <i class="bi bi-clock-fill text-primary"></i>
                        <h3 class="m-0 mt-1 fw-bolder">{{ $pendingHarian }}</h3>
                        <p class="text-secondary m-0">Pending</p>
                    </div>
                    <div class="g-col-4">
                        <i class="bi bi-arrow-repeat text-danger"></i>
                        <h3 class="m-0 mt-1">{{ $revisiHarian }}</h3>
                        <p class="text-secondary m-0">Laporan Terevisi</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="card-title">Laporan Mingguan Berdasarkan Status</h5>
                </div>
                <div class="card-body">
                    <div id="donutChartMingguan"></div>
                </div>
                <div class="grid text-center">
                    <div class="g-col-4">
                        <i class="bi bi-check-circle-fill text-success"></i>
                        <h3 class="m-0 mt-1">{{ $validasiMingguan }}</h3>
                        <p class="text-secondary m-0">Laporan Tervalidasi</p>
                    </div>
                    <div class="g-col-4">
                        <i class="bi bi-clock-fill text-primary"></i>
                        <h3 class="m-0 mt-1 fw-bolder">{{ $pendingMingguan }}</h3>
                        <p class="text-secondary m-0">Laporan Pending</p>
                    </div>
                    <div class="g-col-4">
                        <i class="bi bi-arrow-repeat text-danger"></i>
                        <h3 class="m-0 mt-1">{{ $revisiMingguan }}</h3>
                        <p class="text-secondary m-0">Laporan Terevisi</p>
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

@push('javascript')
<script src="{{ asset('assets/js/apexcharts.min.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Data untuk Laporan Harian
        var validasiHarian = {{ $validasiHarian }};
        var pendingHarian = {{ $pendingHarian }};
        var revisiHarian = {{ $revisiHarian }};
        
        var optionsHarian = {
            series: [validasiHarian, pendingHarian, revisiHarian],
            labels: ['Validasi', 'Pending', 'Revisi'],
            colors: ['#28a745', '#ffc107', '#dc3545'],
            chart: {
                type: 'donut',
                height: 350,
            },
            plotOptions: {
                pie: {
                    donut: {
                        size: '70%'
                    }
                }
            },
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        width: 200
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }]
        };

        var donutChartHarian = new ApexCharts(document.querySelector("#donutChartHarian"), optionsHarian);
        donutChartHarian.render();

        // Data untuk Laporan Mingguan
        var validasiMingguan = {{ $validasiMingguan }};
        var pendingMingguan = {{ $pendingMingguan }};
        var revisiMingguan = {{ $revisiMingguan }};
        
        var optionsMingguan = {
            series: [validasiMingguan, pendingMingguan, revisiMingguan],
            labels: ['Validasi', 'Pending', 'Revisi'],
            colors: ['#28a745', '#ffc107', '#dc3545'],
            chart: {
                type: 'donut',
                height: 350,
            },
            plotOptions: {
                pie: {
                    donut: {
                        size: '70%'
                    }
                }
            },
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        width: 200
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }]
        };

        var donutChartMingguan = new ApexCharts(document.querySelector("#donutChartMingguan"), optionsMingguan);
        donutChartMingguan.render();
    });
</script>
@endpush