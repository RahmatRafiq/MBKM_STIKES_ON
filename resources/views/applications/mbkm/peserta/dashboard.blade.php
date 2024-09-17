@extends('layouts.app')

@section('content')
<!-- App body starts -->
<div class="card-body">
    <!-- Row start -->
    <div class="row gx-3">
        <!-- Kartu Laporan Harian -->
        <div class="col-xl-6 col-sm-6 col-12">
            <div class="card mb-3 card-custom background-gradient-1">
                <div class="card-body">
                    <div class="circle-shape shape-1"></div>
                    <div class="circle-shape shape-2"></div>
                    <div class="circle-shape shape-3"></div>
                    <div class="mb-2">
                        <i class="bi bi-file-earmark-text fs-1 text-white lh-1"></i>
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="m-0 text-white fw-normal">Laporan Harian</h5>
                        <h3 class="m-0 text-white">{{ $totalLaporan }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kartu Laporan Mingguan -->
        <div class="col-xl-6 col-sm-6 col-12">
            <div class="card mb-3 card-custom background-gradient-2">
                <div class="card-body">
                    <div class="circle-shape shape-1"></div>
                    <div class="circle-shape shape-2"></div>
                    <div class="circle-shape shape-3"></div>
                    <div class="mb-2">
                        <i class="bi bi-calendar-week fs-1 text-white lh-1"></i>
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                        <h5 class="m-0 text-white fw-normal">Laporan Mingguan</h5>
                        <h3 class="m-0 text-white">{{ $totalLaporanMingguan }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row gx-3">
        <div class="col-12">
            <div class="card mb-3 card-custom background-gradient-3 shadow-lg">
                <div class="card-body">
                    <div class="circle-shape shape-1"></div>
                    <div class="circle-shape shape-2"></div>
                    <div class="circle-shape shape-3"></div>
    
                    <!-- Title Section with Icon -->
                    <div class="mb-3 d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-briefcase fs-2 text-white lh-1"></i>
                            <h5 class="ms-3 m-0 text-white ">Total Lowongan</h5>
                        </div>
                        <h3 class="m-0 text-white">{{ $totalLowongan }}</h3>
                    </div>
                    <div class="status-details row">
                        <!-- Registered -->
                        <div class="col-md-3 col-6 status-item d-flex justify-content-between align-items-center mb-2">
                            <span class="text-white text-shadow">
                                <i class="bi bi-check-circle-fill me-1"></i>Registered
                            </span>
                            <span class="badge bg-success shadow-sm">{{ $lowonganStatus['registered'] ?? 0 }}</span>
                        </div>
    
                        <!-- Processed -->
                        <div class="col-md-3 col-6 status-item d-flex justify-content-between align-items-center mb-2">
                            <span class="text-white text-shadow">
                                <i class="bi bi-hourglass-split me-1"></i>Processed
                            </span>
                            <span class="badge bg-warning text-dark shadow-sm">{{ $lowonganStatus['processed'] ?? 0 }}</span>
                        </div>
    
                        <!-- Accepted -->
                        <div class="col-md-3 col-6 status-item d-flex justify-content-between align-items-center mb-2">
                            <span class="text-white text-shadow">
                                <i class="bi bi-check-circle me-1"></i>Accepted
                            </span>
                            <span class="badge bg-info text-dark shadow-sm">{{ $lowonganStatus['accepted'] ?? 0 }}</span>
                        </div>
    
                        <!-- Rejected -->
                        <div class="col-md-3 col-6 status-item d-flex justify-content-between align-items-center">
                            <span class="text-white text-shadow">
                                <i class="bi bi-x-circle-fill me-1"></i>Rejected
                            </span>
                            <span class="badge bg-danger shadow-sm">{{ $lowonganStatus['rejected'] ?? 0 }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <style>
        .text-shadow {
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.6);
        }
        </style>
    </div>
    
    <div class="row gx-3">
        <!-- Additional Charts and Statistics -->
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
                        <h3 class="m-0 mt-1">{{ $validasiLaporan }}</h3>
                        <p class="text-secondary m-0">Tervalidasi</p>
                    </div>
                    <div class="g-col-4">
                        <i class="bi bi-clock-fill text-primary"></i>
                        <h3 class="m-0 mt-1 fw-bolder">{{ $pendingLaporan }}</h3>
                        <p class="text-secondary m-0">Pending</p>
                    </div>
                    <div class="g-col-4">
                        <i class="bi bi-arrow-repeat text-danger"></i>
                        <h3 class="m-0 mt-1">{{ $revisiLaporan }}</h3>
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
                        <h3 class="m-0 mt-1">{{ $validasiLaporanMingguan }}</h3>
                        <p class="text-secondary m-0">Tervalidasi</p>
                    </div>
                    <div class="g-col-4">
                        <i class="bi bi-clock-fill text-primary"></i>
                        <h3 class="m-0 mt-1 fw-bolder">{{ $pendingLaporanMingguan }}</h3>
                        <p class="text-secondary m-0">Pending</p>
                    </div>
                    <div class="g-col-4">
                        <i class="bi bi-arrow-repeat text-danger"></i>
                        <h3 class="m-0 mt-1">{{ $revisiLaporanMingguan }}</h3>
                        <p class="text-secondary m-0">Laporan Terevisi</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Row end -->
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
        var optionsHarian = {
            series: [{{ $validasiLaporan }}, {{ $pendingLaporan }}, {{ $revisiLaporan }}],
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
        var optionsMingguan = {
            series: [{{ $validasiLaporanMingguan }}, {{ $pendingLaporanMingguan }}, {{ $revisiLaporanMingguan }}],
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