@extends('layouts.app')

@section('content')
<!-- App body starts -->
<div class="app-body">
    <!-- Row start -->
    <div class="row gx-3">
        <div class="col-xl-3 col-sm-6 col-12">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="mb-2">
                        <i class="bi bi-people fs-1 text-primary lh-1"></i>
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="m-0 text-secondary fw-normal">Peserta Bimbingan</h5>
                        <h3 class="m-0 text-primary">{{ $jumlahPesertaBimbingan }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 col-12">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="mb-2">
                        <i class="bi bi-file-earmark-text fs-1 text-primary lh-1"></i>
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="m-0 text-secondary fw-normal">Laporan Harian</h5>
                        <h3 class="m-0 text-primary">{{ $statistikLaporan['total_harian'] }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 col-12">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="mb-2">
                        <i class="bi bi-calendar-week fs-1 text-primary lh-1"></i>
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="m-0 text-secondary fw-normal">Laporan Mingguan</h5>
                        <h3 class="m-0 text-primary">{{ $statistikLaporan['total_mingguan'] }}</h3>
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
                        <h3 class="m-0 mt-1">{{ $statistikLaporan['validasi_harian'] }}</h3>
                        <p class="text-secondary m-0">Tervalidasi</p>
                    </div>
                    <div class="g-col-4">
                        <i class="bi bi-clock-fill text-primary"></i>
                        <h3 class="m-0 mt-1 fw-bolder">{{ $statistikLaporan['pending_harian'] }}</h3>
                        <p class="text-secondary m-0">Pending</p>
                    </div>
                    <div class="g-col-4">
                        <i class="bi bi-arrow-repeat text-danger"></i>
                        <h3 class="m-0 mt-1">{{ $statistikLaporan['revisi_harian'] }}</h3>
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
                        <h3 class="m-0 mt-1">{{ $statistikLaporan['validasi_mingguan'] }}</h3>
                        <p class="text-secondary m-0">Laporan Tervalidasi</p>
                    </div>
                    <div class="g-col-4">
                        <i class="bi bi-clock-fill text-primary"></i>
                        <h3 class="m-0 mt-1 fw-bolder">{{ $statistikLaporan['pending_mingguan'] }}</h3>
                        <p class="text-secondary m-0">Laporan Pending</p>
                    </div>
                    <div class="g-col-4">
                        <i class="bi bi-arrow-repeat text-danger"></i>
                        <h3 class="m-0 mt-1">{{ $statistikLaporan['revisi_mingguan'] }}</h3>
                        <p class="text-secondary m-0">Laporan Terevisi</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- Tabel Data Peserta -->
        <div class="col-12">
            <div class="card mb-3">
                <div class="card-header">
                    <h5 class="card-title">Data Peserta Bimbingan</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped m-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama Peserta</th>
                                    <th>Lowongan</th>
                                    <th>Mitra</th>
                                    <th>Jumlah Laporan Harian</th>
                                    <th>Jumlah Laporan Mingguan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dataPeserta as $index => $data)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $data['peserta']->nama }}</td>
                                    <td>{{ $data['lowongan'] }}</td>
                                    <td>{{ $data['mitra'] }}</td>
                                    <td>{{ $data['jumlah_laporan_harian'] }}</td>
                                    <td>{{ $data['jumlah_laporan_mingguan'] }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- Row end -->
</div>
<!-- App body ends -->
@endsection

@push('javascript')
<script src="{{ asset('assets/js/apexcharts.min.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Data untuk Laporan Harian
        var validasiCount = {{ $statistikLaporan['validasi_harian'] }};
        var pendingCount = {{ $statistikLaporan['pending_harian'] }};
        var revisiCount = {{ $statistikLaporan['revisi_harian'] }};
        console.log(validasiCount, pendingCount, revisiCount); // Debug data

        var optionsHarian = {
            series: [validasiCount, pendingCount, revisiCount],
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
        var validasiCountMingguan = {{ $statistikLaporan['validasi_mingguan'] }};
        var pendingCountMingguan = {{ $statistikLaporan['pending_mingguan'] }};
        var revisiCountMingguan = {{ $statistikLaporan['revisi_mingguan'] }};
        console.log(validasiCountMingguan, pendingCountMingguan, revisiCountMingguan); // Debug data

        var optionsMingguan = {
            series: [validasiCountMingguan, pendingCountMingguan, revisiCountMingguan],
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