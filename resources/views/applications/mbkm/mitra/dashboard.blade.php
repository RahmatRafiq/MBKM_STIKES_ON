@extends('layouts.app')

@section('content')

<div class="row gx-3">
    <div class="col-md-4 col-sm-6 col-12">
        <div class="card mb-3 card-custom background-gradient-1">
            <div class="card-body">
                <div class="circle-shape shape-1"></div>
                <div class="circle-shape shape-2"></div>
                <div class="circle-shape shape-3"></div>
                <div class="mb-2">
                    <i class="bi bi-people fs-1 text-white lh-1"></i>
                </div>
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="m-0 text-white fw-normal">Peserta</h5>
                    <h3 class="m-0 text-white">{{ $jumlahPeserta }}</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-sm-6 col-12">
        <div class="card mb-3 card-custom background-gradient-2">
            <div class="card-body">
                <div class="circle-shape shape-1"></div>
                <div class="circle-shape shape-2"></div>
                <div class="circle-shape shape-3"></div>
                <div class="mb-2">
                    <i class="bi bi-file-earmark-text fs-1 text-white lh-1"></i>
                </div>
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="m-0 text-white fw-normal">Laporan Harian</h5>
                    <h3 class="m-0 text-white">{{ $laporanHarian }}</h3>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-sm-6 col-12">
        <div class="card mb-3 card-custom background-gradient-3">
            <div class="card-body">
                <div class="circle-shape shape-1"></div>
                <div class="circle-shape shape-2"></div>
                <div class="circle-shape shape-3"></div>
                <div class="mb-2">
                    <i class="bi bi-calendar-week fs-1 text-white lh-1"></i>
                </div>
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="m-0 text-white fw-normal">Laporan Mingguan</h5>
                    <h3 class="m-0 text-white">{{ $laporanMingguan }}</h3>
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
                <h5 class="card-title">Jumlah Pendaftar Terhadap Lowongan</h5>
            </div>
            <div class="card-body table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nama Lowongan</th>
                            <th>Jumlah Pendaftar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($lowongan as $l)
                        <tr>
                            <td>{{ $l->name }}</td>
                            <td>{{ $l->registrations_count }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- App body ends -->
@endsection

@push('css')
<link rel="stylesheet" href="{{ asset('assets/css/customcard.css') }}">
@endpush

@push('javascript')
<script src="{{ asset('assets/js/apexcharts.min.js') }}"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Data untuk Laporan Harian
        var validasiHarian = {{ $validasiHarian }};
        var pendingHarian = {{ $pendingHarian }};
        var revisiHarian = {{ $revisiHarian }};
        console.log(validasiHarian, pendingHarian, revisiHarian); // Debug data

        var optionsHarian = {
            series: [validasiHarian, pendingHarian, revisiHarian],
            labels: ['Validasi', 'Pending', 'Revisi'],
            colors: ['#96e6a1', '#ffd200', '#FF5E62'],
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
            fill: {
                type: 'gradient',
                gradient: {
                    shade: 'dark',
                    type: 'vertical',
                    gradientToColors: ['#96e6a1', '#ffd200', '#FF5E62'],
                    stops: [0, 100]
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
        console.log(validasiMingguan, pendingMingguan, revisiMingguan); // Debug data

        var optionsMingguan = {
            series: [validasiMingguan, pendingMingguan, revisiMingguan],
            labels: ['Validasi', 'Pending', 'Revisi'],
            colors: ['#96e6a1', '#ffd200', '#FF5E62'],
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
            fill: {
                type: 'gradient',
                gradient: {
                    shade: 'dark',
                    type: 'vertical',
                    gradientToColors: ['#96e6a1', '#ffd200', '#FF5E62'],
                    stops: [0, 100]
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